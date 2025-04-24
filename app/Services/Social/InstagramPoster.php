<?php

namespace App\Services\Social;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

use function Termwind\render;

class InstagramPoster
{
    private $accessToken;
    private $igUserId;
    private $templatePath;

    public function __construct(array $config)
    {
        $this->accessToken = $config['access_token'];
        $this->igUserId = $config['ig_user_id'];
        $this->templatePath = resource_path('views/templates/instagram-template.blade.php');

        // Create template directory if it doesn't exist
        if (!File::exists(resource_path('views/templates'))) {
            File::makeDirectory(resource_path('views/templates'), 0755, true);
        }

        // Create the template file if it doesn't exist
        if (!File::exists(path: $this->templatePath)) {
            File::put($this->templatePath, $this->getTemplateHtml());
        }
    }

    private function getTemplateHtml()
    {
        // HTML template with placeholders for title and image
        return <<<'HTML'
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Instagram Post Template</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 1080px;
            height: 1080px;
            overflow: hidden;
            font-family: 'Roboto', Arial, sans-serif;
        }
        .container {
            width: 1080px;
            height: 1080px;
            background-color: #333333;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .image-placeholder {
            width: 800px;
            height: 800px;
            margin-top: 40px;
            background-color: #555555;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .image-placeholder img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .title-placeholder {
            max-width: 900px;
            color: white;
            font-size: 48px;
            font-weight: bold;
            text-align: center;
            margin-top: 30px;
            padding: 0 40px;
            line-height: 1.2;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .logo {
            position: absolute;
            bottom: 30px;
            right: 30px;
            font-size: 24px;
            color: #ffffff;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-placeholder">
            <img src="{{ $imageUrl }}" alt="Article Image" id="article-image">
        </div>
        <div class="title-placeholder" id="article-title">
            {{ $title }}
        </div>
        <div class="logo">{{ $siteName }}</div>
    </div>
</body>
</html>
HTML;
    }

    public function post(Article $article)
    {
        try {
            // Increase execution time for this operation
            $originalTimeLimit = ini_get('max_execution_time');
            set_time_limit(120);

            // Step 1: Generate HTML with article data
            $tempHtmlPath = $this->generateHtml($article);

            // Step 2: Convert HTML to image
            $filename = 'custom/' . uniqid('insta_') . '.jpg';
            $imagePath = Storage::disk('public')->path($filename);
            // $imagePath = $this->convertHtmlToJpg($article, $filename);
            // dd($imagePath);
            // Make sure the directory exists
            $directory = Storage::disk('public')->path('custom');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            Log::info("Before Shot");
            // Use Browsershot to convert HTML to image
            $htmlContent = file_get_contents($tempHtmlPath);
            // render($htmlContent);
            Log::info("After getting content for Shot");
            try {
                Browsershot::html($htmlContent)
                    ->windowSize(1080, 1080)
                    ->deviceScaleFactor(1)
                    ->disableJavascript()
                    ->timeout(120)
                    ->waitUntilNetworkIdle(false)
                    ->noSandbox()
                    ->save($imagePath);
                Log::info("Browsershot conversion successful");
            } catch (\Exception $e) {
                Log::error("Browsershot error: " . $e->getMessage());
                throw $e;
            }
            Log::info("After Shot");

            // Delete temporary HTML file
            unlink($tempHtmlPath);

            // Get the full public URL
            $publicUrl = url('storage/' . $filename);

            // Prepare the caption
            $caption = $article->title . "\n\n" . config('services.frontend.base_url') . "/$article->id";
            Log::info("Posting to Instagram with image URL: " . $publicUrl);

            // Step 3: Create media container using edited image URL
            $containerResponse = Http::post("https://graph.facebook.com/v22.0/{$this->igUserId}/media", [
                'image_url' => $publicUrl,
                'caption' => $caption,
                'access_token' => $this->accessToken
            ]);

            $containerData = $containerResponse->json();
            Log::info('Instagram Container: ' . json_encode($containerData));

            if (!isset($containerData['id'])) {
                Log::error('Instagram container creation failed: ' . json_encode($containerData));
                return false;
            }

            // Step 4: Publish the post
            $publishResponse = Http::post("https://graph.facebook.com/v22.0/{$this->igUserId}/media_publish", [
                'creation_id' => $containerData['id'],
                'access_token' => $this->accessToken
            ]);

            $publishData = $publishResponse->json();
            Log::info('Instagram Publish Response: ' . json_encode($publishData));

            return isset($publishData['id']);

        } catch (\Exception $e) {
            Log::error("Instagram Share Failed: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return false;
        } finally {
            // Make sure to reset the time limit even if an exception occurs
            if (isset($originalTimeLimit)) {
                set_time_limit($originalTimeLimit);
            }
        }
    }

    private function generateHtml(Article $article)
    {
        // Get the image URL from the article's thumbnail
        $imageUrl = $article->thumbnail;

        // Generate HTML content with article data
        $html = view('templates.instagram-template', [
            'title' => $article->title,
            'imageUrl' => $imageUrl,
            'siteName' => parse_url(config('services.frontend.base_url'), PHP_URL_HOST),
            'siteLogo' => config('services.frontend.logo'),
        ])->render();

        // Create a temporary file
        $tempFile = sys_get_temp_dir() . '/' . uniqid('instagram_') . '.html';
        file_put_contents($tempFile, $html);

        return $tempFile;
    }
}