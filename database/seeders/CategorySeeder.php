<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Umum'
        ]);
        Category::create([
            'name' => 'Pendidikan'
        ]);
        Category::create([
            'name' => 'Dakwah'
        ]);
        Category::create([
            'name' => 'Sosial'
        ]);
        Category::create([
            'name' => 'Kesehatan'
        ]);
    }
}
