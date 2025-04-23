<?php
namespace App\Services;

use App\Models\Article;
use App\Services\Social\FacebookPoster;
use App\Services\Social\InstagramPoster;
use App\Services\Social\TwitterPoster;

class SocialShareService
{
    public function share(Article $article, array $credentials)
    {
        if (isset($credentials['facebook'])) {
            (new FacebookPoster($credentials['facebook']))->post($article);
        }

        // if (isset($credentials['instagram'])) {
        //     (new InstagramPoster($credentials['instagram']))->post($article);
        // }

        // if (isset($credentials['twitter'])) {
        //     (new TwitterPoster($credentials['twitter']))->post($article);
        // }
    }
}