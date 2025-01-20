<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\NewsAggregatorService;
use Mockery;

class FetchNewsCommandTest extends TestCase
{
   use RefreshDatabase;
   
    public function test_it_runs_the_news_fetch_command_successfully()
    {
        $aggregatorMock = Mockery::mock(NewsAggregatorService::class);
        $aggregatorMock->shouldReceive('aggregateNews')
                       ->once()
                       ->andReturnTrue();

        $this->app->instance(NewsAggregatorService::class, $aggregatorMock);

        $this->artisan('news:fetch')
             ->expectsOutput('Fetching news...')
             ->expectsOutput('News fetched successfully!')
             ->assertExitCode(0);
    }
}
