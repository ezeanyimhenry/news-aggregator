<?php

namespace App\Console\Commands;

use App\Services\NewsAggregatorService;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news from all configured sources';

    /**
     * Execute the console command.
     */
    public function handle(NewsAggregatorService $aggregator)
    {
        $this->info('Fetching news...');
        $aggregator->aggregateNews();
        $this->info('News fetched successfully!');
    }
}
