<?php

namespace Support\Traits\Models;

use Illuminate\Support\Facades\File;
use function route;

trait HasThumbnail
{
    abstract protected function thumbnailDir(): string;

    public function makeThumbnail(string $size, string $method = 'resize')
    {
        return route('thumbnail', [
            'size' => $size,
            'dir' => $this->thumbnailDir(),
            'method' => $method,
            'file' => File::basename($this->{$this->thumbnailColumn()}),
        ]);
    }

    private function thumbnailColumn(): string
    {
        return 'thumbnail';
    }
}