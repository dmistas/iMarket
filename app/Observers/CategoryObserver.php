<?php

namespace App\Observers;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param Category $Category
     * @return void
     */
    public function created(Category $Category)
    {
        $this->clearCachedCategories();
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  Category  $Category
     * @return void
     */
    public function updated(Category $Category)
    {
        $this->clearCachedCategories();
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  Category  $Category
     * @return void
     */
    public function deleted(Category $Category)
    {
        $this->clearCachedCategories();
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  Category  $Category
     * @return void
     */
    public function restored(Category $Category)
    {
        $this->clearCachedCategories();
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  Category  $Category
     * @return void
     */
    public function forceDeleted(Category $Category)
    {
        $this->clearCachedCategories();
    }

    private function clearCachedCategories()
    {
        Cache::tags(['category'])->flush();
    }
}
