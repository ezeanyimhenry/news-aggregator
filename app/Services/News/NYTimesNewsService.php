<?php 
namespace App\Services\News;

use App\Interfaces\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class NYTimesNewsService implements NewsSourceInterface {
    private $apiKey;
    
    public function __construct() {
        $this->apiKey = config('services.nytimes.api_key');
    }
    
    public function fetchArticles(): array {
        $response = Http::get("https://api.nytimes.com/svc/news/v3/content/all/all.json", [
            'api-key' => $this->apiKey
        ]);
        return $this->formatArticles($response['results']);
    }
    
    private function formatArticles($articles): array {
        return array_map(function($article) {
            return [
                'title' => $article['title'],
                'content' => $article['abstract'],
                'source' => 'New York Times',
                'published_at' => $article['published_date'],
                'url' => $article['url'],
                'category' => $article['section']
            ];
        }, $articles);
    }
}