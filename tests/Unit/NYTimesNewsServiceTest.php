<?php

namespace Tests\Unit;

use App\Services\News\NYTimesNewsService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NYTimesNewsServiceTest extends TestCase
{
    public function test_it_fetches_and_formats_articles_from_nytimes()
    {
        Http::fake([
            'https://api.nytimes.com/svc/news/v3/content/all/all.json*' => Http::response([
                'results' => [
                    [
                        'title' => 'NYTimes Headline',
                        'abstract' => 'NYTimes Content',
                        'published_date' => '2025-01-01',
                        'url' => 'https://example.com/article',
                        'section' => 'World'
                    ]
                ]
            ], 200)
        ]);

        $service = new NYTimesNewsService();
        $articles = $service->fetchArticles();

        $this->assertCount(1, $articles);
        $this->assertEquals('NYTimes Headline', $articles[0]['title']);
        $this->assertEquals('NYTimes Content', $articles[0]['content']);
        $this->assertEquals('New York Times', $articles[0]['source']);
    }
}
