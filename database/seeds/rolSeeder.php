<?php

use Illuminate\Database\Seeder;
use App\Roles;

class rolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::create([
            'rol' => 'admin',
        ]);

        Roles::create([
            'rol' => 'operator',
        ]);

        Roles::create([
            'rol' => 'operator_raion',
        ]);
    }
}
