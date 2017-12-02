<?php

use Illuminate\Database\Seeder;

class commonusermodule extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Alberto Herrera',
            'email' => 'a.herrera07@ufromail.cl',
            'password' => bcrypt('bebote34'),
            'professions_id' => 1,
            'roles_id' => 1,
            'confirmed' => 1
        ]);


        DB::table('projects')->insert([
            'name' => 'Municipalidad Valdivia',
            'description' => 'ERP para la gestión de la Municipalidad',
            'time' => '22:14',
            'date' => '22-01-2014',
            'users_id' => 1,
            'areas_id' => 1,
            'deadline' => '22-05-2015'
        ]);


        

    }
}
