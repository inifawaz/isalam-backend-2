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
            'name' => 'Tutorial'
        ]);
        Topic::create([
            'name' => 'Pengumuman'
        ]);
        Topic::create([
            'name' => 'Fiqih Muamalah'
        ]);
        Topic::create([
            'name' => 'Umum'
        ]);
    }
}
