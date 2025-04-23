<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        // Apply search filter
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Apply date filter
        if ($request->has('date_from')) {
            $query->where('published_at', '>=', $request->get('date_from'));
        }
        if ($request->has('date_to')) {
            $query->where('published_at', '<=', $request->get('date_to'));
        }

        // Apply category filter
        if ($request->has('category')) {
            $query->where('category', $request->get('category'));
        }

        // Apply source filter
        if ($request->has('source')) {
            $query->where('source', 'like', "%{$request->get('source')}%");
        }

        $perPage = $request->get('per_page', 20);
        $articles = $query->orderBy('published_at', 'desc')->paginate($perPage);

        $response = ['status' => 'success', 'data' => $articles];

        if ($request->boolean('include_meta')) {
            $response['meta'] = [
                'categories' => Article::select('category')->distinct()->whereNotNull('category')->pluck('category')->sort()->values(),
                'sources' => Article::select('source')->distinct()->whereNotNull('source')->pluck('source')->sort()->values(),
                'source_counts' => Article::select('source')
                    ->whereNotNull('source')
                    ->groupBy('source')
                    ->selectRaw('source, COUNT(*) as total')
                    ->pluck('total', 'source'),
            ];
        }

        return response()->json($response);
    }

    public function random(Request $request)
    {
        $count = $request->get('count', 6);
        $articles = Article::inRandomOrder()
            ->limit($count)
            ->get();

        return response()->json(['status' => 'success', 'data' => $articles]);
    }

    public function byCategory(Request $request)
    {
        $category = $request->get('category');
        $count = $request->get('count', 6);

        $query = Article::where('category', $category);

        if ($request->boolean('random', true)) {
            $query->inRandomOrder();
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $articles = $query->limit($count)->get();

        return response()->json(['status' => 'success', 'data' => $articles]);
    }

    public function bySource(Request $request)
    {
        $source = $request->get('source');
        $count = $request->get('count', 6);

        $query = Article::where('source', 'like', "%$source%");

        if ($request->boolean('random', true)) {
            $query->inRandomOrder();
        } else {
            $query->orderBy('published_at', 'desc');
        }

        $articles = $query->limit($count)->get();

        return response()->json(['status' => 'success', 'data' => $articles]);
    }

    public function byId(Article $article)
    {
        return response()->json(['status' => 'success', 'data' => $article]);
    }

}