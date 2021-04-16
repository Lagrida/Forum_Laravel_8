<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'LAGRIDA Yassine',
            'username' => 'lagrida',
            'email' => 'lagyassine@gmail.com',
            'image' => 'https://demos.lagrida.com/files/images/lagrida.png',
            'password' => Hash::make('123456')
        ]);
        DB::table('users')->insert([
            'name' => 'Leonhard Euler',
            'username' => 'euler',
            'email' => 'euler@gmail.com',
            'image' => 'https://demos.lagrida.com/files/images/euler.png',
            'password' => Hash::make('123456')
        ]);
        DB::table('users')->insert([
            'name' => 'carl GAUSS',
            'username' => 'gauss',
            'email' => 'gauss@gmail.com',
            'image' => 'https://demos.lagrida.com/files/images/gauss.png',
            'password' => Hash::make('123456')
        ]);
		
		$lagrida = User::where('username', 'lagrida')->first();
		$euler = User::where('username', 'euler')->first();
		$gauss = User::where('username', 'gauss')->first();
		
		$lagrida->assignRole('admin');
		$euler->assignRole('monitor');
		$gauss->assignRole('user');
    }
}
