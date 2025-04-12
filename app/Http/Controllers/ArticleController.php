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
        return $query->paginate($perPage);
    }
}