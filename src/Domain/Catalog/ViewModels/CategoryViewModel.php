<?php

namespace Domain\Catalog\ViewModels;

use Domain\Catalog\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class CategoryViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::tags(['category'])
            ->rememberForever('category_home_page', function () {
                return Category::query()
                    ->homePage()
                    ->get();
            });
    }

    public function catalogPage(): Collection|array
    {
        return Cache::tags(['category'])
            ->rememberForever('category_catalog_page', function () {
                return Category::query()
                    ->catalogPage()
                    ->get();
            });
    }
}
