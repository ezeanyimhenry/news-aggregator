<?php

namespace Tests\Unit;

use App\Services\News\NewsAPIService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NewsAPIServiceTest extends TestCase
{
    public function test_it_fetches_and_formats_articles_from_newsapi()
    {
        Http::fake([
            'https://newsapi.org/v2/top-headlines*' => Http::response([
                'articles' => [
                    [
                        'title' => 'NewsAPI Headline',
                        'description' => 'NewsAPI Content',
                        'source' => ['name' => 'NewsAPI'],
                        'publishedAt' => '2025-01-01',
                        'url' => 'https://example.com/article'
                    ]
                ]
            ], 200)
        ]);

        $service = new NewsAPIService();
        $articles = $service->fetchArticles();

        $this->assertCount(1, $articles);
        $this->assertEquals('NewsAPI Headline', $articles[0]['title']);
        $this->assertEquals('NewsAPI Content', $articles[0]['content']);
        $this->assertEquals('NewsAPI', $articles[0]['source']);
    }
}
