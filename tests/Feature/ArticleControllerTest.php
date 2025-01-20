<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_it_fetches_articles_without_filters()
    {
        Article::factory()->count(5)->create();

        $response = $this->getJson('/api/articles?per_page=5');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data');
    }

    
    public function test_it_fetches_articles_with_search_filter()
    {
        Article::factory()->create(['title' => 'Breaking News']);
        Article::factory()->create(['title' => 'Regular News']);

        $response = $this->getJson('/api/articles?search=breaking');

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data')
                 ->assertJsonFragment(['title' => 'Breaking News']);
    }

    
    public function test_it_fetches_articles_with_date_range_filter()
    {
        Article::factory()->create(['published_at' => now()->subDays(2)]);
        Article::factory()->create(['published_at' => now()->subDays(5)]);

        $response = $this->getJson('/api/articles?date_from=' . now()->subDays(3)->toDateString());

        $response->assertStatus(200)
                 ->assertJsonCount(1, 'data');
    }

    
    public function test_it_fetches_articles_with_source_filter()
    {
        Article::factory()->create(['source' => 'The Guardian']);
        Article::factory()->create(['source' => 'NYTimes']);

        $response = $this->getJson('/api/articles?source=The Guardian');

        $response->assertStatus(200)
                 ->assertJsonFragment(['source' => 'The Guardian']);
    }

    
    public function test_it_paginates_articles()
    {
        Article::factory()->count(30)->create();

        $response = $this->getJson('/api/articles?per_page=20');

        $response->assertStatus(200)
                 ->assertJsonCount(20, 'data');
    }
}
