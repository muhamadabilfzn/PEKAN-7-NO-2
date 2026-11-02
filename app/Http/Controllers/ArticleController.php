<?php

namespace App\Http\Controllers;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index', [
            'artikel' => Article::with('penulis')->published()->orderByDesc('created_at')->limit(20)->get(),
        ]);
    }

    public function show(string $slug)
    {
        $artikel = Article::with('penulis')->published()->where('slug', $slug)->firstOrFail();

        return view('articles.show', compact('artikel'));
    }
}
