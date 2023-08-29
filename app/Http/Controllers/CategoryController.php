<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {   
        // $categories = Category::all();
        // return response()->json(compact('categories'));
        
        return new CategoryCollection(Category::all());
    }
}
