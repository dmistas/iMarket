<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            $item->slug = $item->slug
                ?? str($item->{self::slugFrom()})
                    ->append(self::calculatePostfix($item))
                    ->slug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }

    protected static function calculatePostfix(Model $item): string
    {
        $countOfUse = DB::table($item->getTable())->where(self::slugFrom(), $item->{self::slugFrom()})->count();

        if ($countOfUse) {
            return '_' . $countOfUse + 1;
        }
        return '';
    }
}
