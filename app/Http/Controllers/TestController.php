<?php
namespace App\Http\Controllers;

use App\Services\News\GuardianNewsService;
use App\Services\News\NYTimesNewsService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(string $service, GuardianNewsService $newsService, NYTimesNewsService $timesNewsService)
    {
        if ($service == 'guardian') {
            return $newsService->fetchArticles();
        } elseif ($service == 'nytimes') {
            return $timesNewsService->fetchArticles();
        }
    }
}