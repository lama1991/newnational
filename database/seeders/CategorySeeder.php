<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'كلية هندسية',
            'logo' => Str::random(10)
           
        ]);
        DB::table('categories')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'كلية طبية',
            'logo' => Str::random(10)
           
        ]);
    }
}
