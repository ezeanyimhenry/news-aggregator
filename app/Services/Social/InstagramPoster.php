<?php

namespace App\Services\Social;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramPoster
{
    private $accessToken;
    private $igUserId;

    public function __construct(array $config)
    {
        $this->accessToken = $config['access_token'];
        $this->igUserId = $config['ig_user_id'];
    }

    public function post(Article $article)
    {
        try {
            $caption = $article->title . "\n\n" . config('services.frontend.base_url') . "/$article->id";

            // Step 1: Create a media container
            $containerResponse = Http::post("https://graph.facebook.com/v22.0/{$this->igUserId}/media", [
                'image_url' => $article->thumbnail,
                'caption' => $caption,
                'access_token' => $this->accessToken
            ]);

            $containerData = $containerResponse->json();

            if (!isset($containerData['id'])) {
                return;
            }

            // Step 2: Publish the container
            $publishResponse = Http::post("https://graph.facebook.com/v22.0/{$this->igUserId}/media_publish", [
                'creation_id' => $containerData['id'],
                'access_token' => $this->accessToken
            ]);

        } catch (\Exception $e) {
            Log::error("Instagram Share Failed: " . $e->getMessage());
        }
    }
}