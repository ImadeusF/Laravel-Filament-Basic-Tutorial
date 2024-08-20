<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function showAllCategories()
    {
        return view('categories', [
            'categories' => Categories::latest()->paginate(5)
        ]);
    }
}
