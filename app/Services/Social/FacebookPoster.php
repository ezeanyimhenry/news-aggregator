<?php
namespace App\Services\Social;

use App\Models\Article;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookPoster
{
    private $accessToken;
    private $pageId;

    public function __construct(array $config)
    {
        $this->accessToken = $config['access_token'];
        $this->pageId = $config['page_id'];
    }

    public function post(Article $article)
    {
        try {
            Http::post("https://graph.facebook.com/v22.0/{$this->pageId}/feed", [
                'message' => $article->title,
                'link' => config('services.frontend.base_url') . "/$article->id",
                'access_token' => $this->accessToken
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to Share to Facebook: $e");
        }
    }
}