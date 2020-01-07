<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'economia',
            'email' => 'economia-lapaz@nuevaacropolis.org',
            'avatar' => ['url' => 'https://www.meteorologiaenred.com/wp-content/uploads/2019/04/Pit%C3%A1goras.jpg'],
            'password' => Hash::make('12345678'),
            'ultimo_aporte' => 'Enero/2019',
            'iniciales' => 'EC',
        ]);
    }
}
