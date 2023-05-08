<?php

namespace App\Observers;

use Domain\Catalog\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    /**
     * Handle the Brand "created" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function created(Brand $brand)
    {
        $this->clearCachedBrands();
    }

    /**
     * Handle the Brand "updated" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function updated(Brand $brand)
    {
        $this->clearCachedBrands();
    }

    /**
     * Handle the Brand "deleted" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function deleted(Brand $brand)
    {
        $this->clearCachedBrands();
    }

    /**
     * Handle the Brand "restored" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function restored(Brand $brand)
    {
        $this->clearCachedBrands();
    }

    /**
     * Handle the Brand "force deleted" event.
     *
     * @param  Brand  $brand
     * @return void
     */
    public function forceDeleted(Brand $brand)
    {
        $this->clearCachedBrands();
    }

    private function clearCachedBrands()
    {
        Cache::tags(['brand'])->flush();
    }
}
