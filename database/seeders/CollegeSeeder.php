<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colleges')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'الهندسة المعلوماتية',
            'category_id'=>1,
            'logo' => Str::random(10)
           
        ]);
        DB::table('colleges')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'الهندسة المعمارية',
            'category_id'=>1,
            'logo' => Str::random(10)
           
        ]);
        DB::table('colleges')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'طب الأسنان ',
            'category_id'=>2,
            'logo' => Str::random(10)
           
        ]);
    }
}
