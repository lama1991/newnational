<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'ما هي أطر العمل المبنية على لغة البرمجة php',
            'reference'=>'تطوير الويب',
            'term_id'=>1,
            'specialization_id'=>1,
            'college_id'=>1,


        ]);
        DB::table('questions')->insert([
            'uuid' => Str::uuid()->toString(),
            'content' => 'ما هو بروتوكول نقل الملفات',
            'reference'=>'مفاهيم الشبكات',
            'term_id'=>1,
            'specialization_id'=>2,
            'college_id'=>1,


        ]);
    }
}
