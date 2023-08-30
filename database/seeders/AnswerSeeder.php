<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'ريأكت',
            'is_true'=>false,
            'question_id'=>1
        ]);
        DB::table('answers')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'لارافيل',
            'is_true'=>true,
            'question_id'=>1
        ]);
        DB::table('answers')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'أنجولار',
            'is_true'=>false,
            'question_id'=>1
        ]);
        DB::table('answers')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'FTP',
            'is_true'=>true,
            'question_id'=>1
        ]);
        DB::table('answers')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'UDP',
            'is_true'=>false,
            'question_id'=>1
        ]);
        DB::table('answers')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'STP',
            'is_true'=>false,
            'question_id'=>1
        ]);
    }
}
