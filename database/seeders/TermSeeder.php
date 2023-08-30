<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('terms')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'دورة الربيع 2022',
            'specialization_id'=>1,


        ]);
        DB::table('terms')->insert([
            'uuid' => Str::uuid()->toString(),
            'name' => 'دورة تشرين الأول 2022',
            'specialization_id'=>1,


        ]);

    }
}
