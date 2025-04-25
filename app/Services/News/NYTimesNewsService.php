<?php
namespace App\Services\News;

use App\Interfaces\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class NYTimesNewsService implements NewsSourceInterface
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.nytimes.api_key');
    }

    public function fetchArticles(): array
    {
        $response = Http::get("https://api.nytimes.com/svc/news/v3/content/all/all.json", [
            'api-key' => $this->apiKey
        ]);

        return $this->formatArticles($response['results']);
    }

    private function formatArticles($articles): array
    {
        return array_map(function ($article) {
            $imageUrl = null;

            if (!empty($article['multimedia'])) {
                // Try to find the best image format
                foreach ($article['multimedia'] as $media) {
                    if ($media['format'] === 'Normal') {
                        $imageUrl = $media['url'];
                        break;
                    }
                }

                // Fallback to the first available image
                if (!$imageUrl && isset($article['multimedia'][0]['url'])) {
                    $imageUrl = $article['multimedia'][1]['url'];
                }
            }

            return [
                'title' => $article['title'],
                'content' => $article['abstract'],
                'source' => 'New York Times',
                'published_at' => $article['published_date'],
                'url' => $article['url'],
                'category' => $article['section'],
                'thumbnail' => $imageUrl
            ];
        }, $articles);
    }
}