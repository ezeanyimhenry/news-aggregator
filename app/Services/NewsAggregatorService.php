<?php 
namespace App\Services;

use App\Interfaces\NewsSourceInterface;
use App\Models\Article;
use Illuminate\Support\Facades\Log;

class NewsAggregatorService {
    private $sources = [];
    
    public function addSource(NewsSourceInterface $source) {
        $this->sources[] = $source;
    }
    
    public function aggregateNews() {
        $allArticles = [];
        
        foreach ($this->sources as $source) {
            try {
                $articles = $source->fetchArticles();
                $allArticles = array_merge($allArticles, $articles);
            } catch (\Exception $e) {
                Log::error('Error fetching articles from ' . get_class($source) . ': ' . $e->getMessage());
                continue;
            }
        }
        
        foreach ($allArticles as $article) {
            try {
                Article::updateOrCreate(
                    ['url' => $article['url']],
                    $article
                );
            } catch (\Exception $e) {
                Log::error('Error saving article: ' . $e->getMessage());
                continue;
            }
        }
    }
}