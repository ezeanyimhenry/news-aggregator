<?php

namespace App\Services\Social;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InstagramPoster
{
    private $accessToken;
    private $igUserId;

    public function __construct(array $config)
    {
        $this->accessToken = $config['access_token'];
        $this->igUserId = $config['ig_user_id'];
    }

    public function post(Article $article)
    {
        try { // Create media container
            $container = Http::post("https://graph.facebook.com/v18.0/{$this->igUserId}/media", [
                'image_url' => $article->thumbnail,
                'caption' => $article->title . "\n\n" . $article->url,
                'access_token' => $this->accessToken
            ]);

            // Publish it
            Http::post("https://graph.facebook.com/v18.0/{$this->igUserId}/media_publish", [
                'creation_id' => $container['id'],
                'access_token' => $this->accessToken
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to Share to Instagram: $e");
        }
    }
}