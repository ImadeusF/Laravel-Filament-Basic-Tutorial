<?php

namespace App\Http\Controllers;

use App\Models\Articles;


class ArticlesController extends Controller
{
    public function showAllArticles()
    {
        return view('articles', [
            'articles' => articles::latest()->paginate(3)
        ]);
    }

    public function showByCategory($category)
    {
        return view('articles', [
            'articles' => articles::where('category_id', $category)->latest()->paginate(3)
        ]);
    }
}
