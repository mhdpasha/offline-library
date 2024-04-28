<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'no_induk' => '12510',
            'nama' => 'Muhamad Pasha Albara',
            'email' => 'pasha@gmail.com',
            'password' => Hash::make('pasha'),
            'tempatlahir' => 'Jakarta',
            'tanggallahir' => '2006-10-01',
            'role' => 'admin' 
        ]);
        User::create([
            'no_induk' => '12511',
            'nama' => 'David Laid',
            'email' => 'david@gmail.com',
            'password' => Hash::make('david'),
            'tempatlahir' => 'New York',
            'tanggallahir' => '2003-12-23',
            'role' => 'pustakawan' 
        ]);
        User::create([
            'no_induk' => '12512',
            'nama' => 'Sergei Dragunov',
            'email' => 'sergei@gmail.com',
            'password' => Hash::make('sergei'),
            'tempatlahir' => 'Moscow',
            'tanggallahir' => '1997-02-12',
            'role' => 'user' 
        ]);
        User::create([
            'no_induk' => '12513',
            'nama' => 'Que Pasa',
            'email' => 'quepasa@gmail.com',
            'password' => Hash::make('quepasa'),
            'tempatlahir' => 'Mexico',
            'tanggallahir' => '2001-04-02',
            'role' => 'user' 
        ]);
    }
}
