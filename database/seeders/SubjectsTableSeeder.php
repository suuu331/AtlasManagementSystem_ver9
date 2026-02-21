<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 国語、数学、英語を追加
        \DB::table('subjects')->insert([
        ['subject' => '国語', 'created_at' => now()],
        ['subject' => '数学', 'created_at' => now()],
        ['subject' => '英語', 'created_at' => now()],
    ]);
    }
}
