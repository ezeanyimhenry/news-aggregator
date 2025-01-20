<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\NewsAggregatorService;
use App\Services\News\GuardianNewsService;
use App\Services\News\NYTimesNewsService;
use App\Services\News\NewsAPIService;

class NewsServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton(NewsAggregatorService::class, function ($app) {
            $aggregator = new NewsAggregatorService();
            
            // Register news sources
            $aggregator->addSource($app->make(GuardianNewsService::class));
            $aggregator->addSource($app->make(NYTimesNewsService::class));
            $aggregator->addSource($app->make(NewsAPIService::class));
            
            return $aggregator;
        });
    }
}