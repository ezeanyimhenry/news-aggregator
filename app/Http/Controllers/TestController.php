<?php
namespace App\Http\Controllers;

use App\Services\News\GuardianNewsService;
use App\Services\News\NewsAPIService;
use App\Services\News\NYTimesNewsService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(string $service, GuardianNewsService $newsService, NYTimesNewsService $timesNewsService, NewsAPIService $newsAPIService)
    {
        if ($service == 'guardian') {
            return $newsService->fetchArticles();
        } elseif ($service == 'nytimes') {
            return $timesNewsService->fetchArticles();
        } elseif ($service == 'newsapi') {
            return $newsAPIService->fetchArticles();
        }
    }
}