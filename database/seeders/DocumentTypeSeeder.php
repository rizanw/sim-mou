<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('document_types')->insert([
            [
                'name' => 'Letter of Intent',
                'shortname' => 'LoI',
            ],
            [
                'name' => 'Memorandum of Understanding',
                'shortname' => 'MoU',
            ],
            [
                'name' => 'Memorandum of Aggrement',
                'shortname' => 'MoA',
            ],
            [
                'name' => 'Implementation Arrangement',
                'shortname' => 'IA',
            ],
        ]);
    }
}
