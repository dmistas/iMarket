<?php

namespace Tests\Feature\App\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ThumbnailControllerTest extends TestCase
{
    private array $requestParams = [
        'dir' => 'tmp',
        'method' => 'resize',
        'size' => '70x70',
        'file' => ''
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->requestParams['file'] = $this->prepareFakeImage();
    }

    public function test_it_success_resize(): void
    {
        $this->assertTrue(in_array($this->requestParams['size'], config('thumbnail.allowed_sizes', [])));
        $response = $this->get(route('thumbnail', $this->requestParams))
            ->assertOk();

        $this->assertEquals($this->requestParams['file'], $response->getFile()->getFilename());
        $this->assertTrue(str_contains($response->getFile()->getPath(), $this->requestParams['size']));
    }

    public function test_it_forbidden_size_not_allowed()
    {
        $this->requestParams['size'] = '1x1';

        $this->assertTrue(!in_array($this->requestParams['size'], config('thumbnail.allowed_sizes', [])));

        $response = $this->get(route('thumbnail', $this->requestParams))
            ->assertForbidden();
    }

    private function prepareFakeImage(): string
    {
        Storage::fake('images');

        $image = UploadedFile::fake()->image('thumbnail_test.jpg', 1024, 768);

        Storage::disk('images')->putFileAs('tmp', $image, $image->name);

        return $image->name;
    }
}
