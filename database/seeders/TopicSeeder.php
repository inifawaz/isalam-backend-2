<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Topic::create([
            'name' => 'Pendidikan'
        ]);
        Topic::create([
            'name' => 'Sosial'
        ]);
        Topic::create([
            'name' => 'Dakwah'
        ]);
        Topic::create([
            'name' => 'Umum'
        ]);
    }
}
