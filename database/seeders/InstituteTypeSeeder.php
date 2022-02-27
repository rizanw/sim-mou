<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituteTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institute_types')->insert([
            ['name' => 'University'],
            ['name' => 'Company'],
            ['name' => 'Institution'],
            ['name' => 'Organization'],
            ['name' => 'Consortium'],
        ]);
    }
}
