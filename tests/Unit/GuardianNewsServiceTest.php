<?php

namespace Tests\Unit;

use App\Services\News\GuardianNewsService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GuardianNewsServiceTest extends TestCase
{
    public function test_it_fetches_and_formats_articles_from_guardian_api()
    {
        Http::fake([
            'https://content.guardianapis.com/search*' => Http::response([
                'response' => [
                    'results' => [
                        [
                            'fields' => [
                                'headline' => 'Guardian Headline',
                                'bodyText' => 'Guardian Content',
                                'publication' => '2025-01-01',
                                'thumbnail' => 'image.jpg',
                                'lastModified' => '2025-01-02'
                            ],
                            'webPublicationDate' => '2025-01-01',
                            'webUrl' => 'https://example.com/article',
                            'sectionName' => 'World'
                        ]
                    ]
                ]
            ], 200)
        ]);

        $service = new GuardianNewsService();
        $articles = $service->fetchArticles();

        $this->assertCount(1, $articles);
        $this->assertEquals('Guardian Headline', $articles[0]['title']);
        $this->assertEquals('Guardian Content', $articles[0]['content']);
        $this->assertEquals('The Guardian', $articles[0]['source']);
    }
}
