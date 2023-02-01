<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
    ];

    protected static function boot()
    {
        parent::boot();

        // TODO: refactor
        static::creating(function (Brand $brand) {
            $this->slug = $this->slug ?? str($brand->title)->slug();
        });
    }
}
