<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        return Category::query()
            ->where('is_active', true)
            ->withCount(['availableProducts as products_count'])
            ->orderBy('display_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'description']);
    }
}
