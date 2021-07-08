<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

class ibanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fisier = public_path().'/iban_2021.csv';
        $csv = Reader::createFromPath($fisier);
        foreach ($csv as $row) {
            \DB::table('i_b_a_n_s')->insert(
                array(
                'kd_eco' => $row[0],
                'kd_local' => $row[1],
                'kd_trez' => $row[2],
                'iban' => $row[3]
                ));

        }
    }
}
