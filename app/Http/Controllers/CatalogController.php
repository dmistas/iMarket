<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Domain\Catalog\Models\Category;
use Domain\Catalog\ViewModels\BrandViewModel;
use Domain\Catalog\ViewModels\CategoryViewModel;

class CatalogController extends Controller
{
    public function __invoke(?Category $category)
    {
        $brands = BrandViewModel::make()->catalogPage();

        $categories = CategoryViewModel::make()->catalogPage();

        $products = Product::query()
            ->paginate(6);

        return view('catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'category' => $category
        ]);
    }
}
