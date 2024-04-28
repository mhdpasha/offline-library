<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::create([
            'nama' => 'Fiksi',
            'kode' => 'AR-FIK',
            'status' => 'aktif'
        ]);
        Kategori::create([
            'nama' => 'Non-Fiksi',
            'kode' => 'AR-NONF',
            'status' => 'aktif'
        ]);
        Kategori::create([
            'nama' => 'Pendidikan',
            'kode' => 'AR-PEND',
            'status' => 'aktif'
        ]);
        Kategori::create([
            'nama' => 'Filosofi',
            'kode' => 'AR-FLSF',
            'status' => 'aktif'
        ]);
    }
}
