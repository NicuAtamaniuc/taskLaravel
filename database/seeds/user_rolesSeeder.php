<?php

use Illuminate\Database\Seeder;
use App\Role_user;

class user_rolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role_user::create([
            'id_user' => '2',
            'id_rol' => '1'
        ]);
    }
}
