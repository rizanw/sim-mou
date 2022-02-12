<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('continents')->insert([
            'name' => 'Africa',
            'id' => 'AF',
        ]);
        DB::table('continents')->insert([
            'name' => 'Antarctica',
            'id' => 'AN',
        ]);
        DB::table('continents')->insert([
            'name' => 'Asia',
            'id' => 'AS',
        ]);
        DB::table('continents')->insert([
            'name' => 'Europe',
            'id' => 'EU',
        ]);
        DB::table('continents')->insert([
            'name' => 'North America',
            'id' => 'NA',
        ]);
        DB::table('continents')->insert([
            'name' => 'Oceania',
            'id' => 'OC',
        ]);
        DB::table('continents')->insert([
            'name' => 'South America',
            'id' => 'SA',
        ]);
    }
}
