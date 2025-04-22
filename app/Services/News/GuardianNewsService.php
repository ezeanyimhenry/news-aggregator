<?php
namespace App\Services\News;

use App\Interfaces\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class GuardianNewsService implements NewsSourceInterface
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.guardian.api_key');
    }

    public function fetchArticles(): array
    {
        $response = Http::get("https://content.guardianapis.com/search", [
            'api-key' => $this->apiKey,
            'show-fields' => 'headline,bodyText,thumbnail,publication,lastModified'
        ]);
        return $this->formatArticles($response['response']['results']);
    }

    private function formatArticles($articles): array
    {
        return array_map(function ($article) {
            return [
                'title' => $article['fields']['headline'],
                'content' => $article['fields']['bodyText'],
                'source' => 'The Guardian',
                'published_at' => $article['webPublicationDate'],
                'url' => $article['webUrl'],
                'category' => $article['sectionName'],
                'thumbnail' => $article['fields']['thumbnail'] ?? null,
            ];
        }, $articles);
    }
}