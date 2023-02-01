<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // TODO: refactor
        static::creating(function (Category $category) {
            $this->slug = $this->slug ?? str($category->title)->slug();
        });
    }
}
