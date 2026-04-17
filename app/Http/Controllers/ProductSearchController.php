<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Services\ProductSearchService;
use Illuminate\View\View;

class ProductSearchController extends Controller
{
    public function index(ProductSearchRequest $request, ProductSearchService $searchService): View
    {
        $products = $searchService->search($request);

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        $brands = Brand::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('products.search', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}