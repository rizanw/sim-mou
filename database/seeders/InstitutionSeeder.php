<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institutions')->insert([
            [
                'institution_type_id' => 1,
                'name' => 'Institut Teknologi Sepuluh Nopember',
                'label' => 'INSTITUTION',
                'country_id' => 'ID',
                'address' => 'Jl. Teknik Kimia, Keputih, Kec. Sukolilo, Kota SBY, Jawa Timur 60111',
                'telp' => '',
                'email' => '',
                'website' => 'its.ac.id',
                'is_partner' => false,
            ],
        ]);
    }
}
