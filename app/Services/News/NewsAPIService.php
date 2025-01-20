<?php
namespace App\Services\News;

use App\Interfaces\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class NewsAPIService implements NewsSourceInterface {
    private $apiKey;
    
    public function __construct() {
        $this->apiKey = config('services.newsapi.api_key');
    }
    
    public function fetchArticles(): array {
        $response = Http::get("https://newsapi.org/v2/top-headlines", [
            'apiKey' => $this->apiKey,
            'language' => 'en'
        ]);
        
        return $this->formatArticles($response['articles']);
    }
    
    private function formatArticles($articles): array {
        return array_map(function($article) {
            return [
                'title' => $article['title'],
                'content' => $article['description'],
                'source' => $article['source']['name'],
                'published_at' => $article['publishedAt'],
                'url' => $article['url'],
                'category' => 'general'
            ];
        }, $articles);
    }
}