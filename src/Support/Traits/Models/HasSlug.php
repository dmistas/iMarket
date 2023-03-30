<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;
use function str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }

    protected function makeSlug()
    {
        $this->{$this->slugColumn()} =
            $this->{$this->slugColumn()} ??
            $this->slugUnique(str($this->{$this->slugFrom()})->slug()->value());
    }

    protected function slugColumn()
    {
        return 'slug';
    }

    protected function slugFrom(): string
    {
        return 'title';
    }

    protected function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 1;

        while ($this->isSlugExists($slug)) {
            $i++;
            $slug = $originalSlug . '-' . $i;
        }

        return $slug;
    }

    protected function isSlugExists(string $slug)
    {
        $query = $this->newQuery()
            ->where($this->slugColumn(), $slug)
            ->withoutGlobalScopes();
        return $query->exists();
    }
}
