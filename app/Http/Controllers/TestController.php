<?php 
namespace App\Http\Controllers;

use App\Services\News\GuardianNewsService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test(GuardianNewsService $newsService)
    {
        return $newsService->fetchArticles();
    }
}