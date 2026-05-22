<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', 1)
            ->orderByDesc('published_at')
            ->paginate(10);

        return NewsResource::collection($news);
    }

    public function show($id)
    {
        $item = News::where('is_published', 1)->findOrFail($id);

        return new NewsResource($item);
    }
}

