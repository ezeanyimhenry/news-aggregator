<?php
namespace App\Services\Social;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwitterPoster
{
    private $accessToken;

    public function __construct(array $config)
    {
        $this->accessToken = $config['access_token'];
    }

    public function post(Article $article)
    {
        try {
            Http::withToken($this->accessToken)->post('https://api.twitter.com/2/tweets', [
                'text' => $article->title . ' ' . $article->url
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to Share to Twitter: $e");
        }
    }
}