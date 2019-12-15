<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Economía',
            'icon' => 'fas fa-coins',
        ]);
        Category::create([
            'name' => 'Escolástica',
            'icon' => 'fas fa-book-reader',
        ]);
    }
}
