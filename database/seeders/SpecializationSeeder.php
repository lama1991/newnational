<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('specializations')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'برمجيات ',
            'college_id'=>1,
           
           
        ]);
        DB::table('specializations')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'شبكات ',
            'college_id'=>1,
           
           
        ]);
     
    }
}
