<?php
namespace App\Services\Social;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Article;
use App\Notifications\TweetNotification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwitterPoster
{

    public function post(Article $article)
    {
        try {
            $article->notify(new TweetNotification($article));
        } catch (\Exception $e) {
            Log::error("Twitter post failed: " . $e->getMessage());
        }
    }

}