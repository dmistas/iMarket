<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()->count(20)->create();
        CategoryFactory::new()->count(20)
            ->has(ProductFactory::new()->count(rand(10, 20)))
            ->create();
    }
}
