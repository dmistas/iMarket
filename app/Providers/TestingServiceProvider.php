<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Base;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class TestingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Generator::class, function () {
            $faker = Factory::create();
            $fixtureProvider = new class ($faker) extends Base {
                public function fixturesImage(
                    string $fixturesDir = '',
                    string $storageDir = ''
                ): string
                {
                    if (!File::exists(base_path("tests/Fixtures/images/$fixturesDir/"))) {
                        return false;
                    }
                    if (!Storage::exists($storageDir)) {
                        Storage::makeDirectory($storageDir);
                    }

                    $file = $this->generator->file(
                        base_path("tests/Fixtures/images/$fixturesDir"),
                        Storage::path($storageDir),
                        false
                    );

                    return '/storage/' . trim($storageDir, '/') . '/' . $file;
                }
            };
            $faker->addProvider($fixtureProvider);
            return $faker;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
