<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\DetailBuku;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Traits\GenerateSlug;

class BukuSeeder extends Seeder
{
    use GenerateSlug;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $kategori_id = 4;
        $judul = "Filosofi Teras";
        $stok = 5;
        

        Buku::create([
            'kategori_id' => $kategori_id,
            'judul' => $judul,
            'pengarang' => 'Henry Manampiring',
            'penerbit' => 'Gramedia',
            'deskripsi' => 'Lebih dari 2.000 tahun lalu, sebuah mazhab filsafat menemukan akar masalah dan juga solusi dari banyak emosi negatif. Stoisisme, atau Filosofi Teras, adalah filsafat Yunani-Romawi kuno yang bisa membantu kita mengatasi emosi negatif dan menghasilkan mental yang tangguh dalam menghadapi naik-turunnya kehidupan.',
            'image' => 'https://gerai.kompas.id/wp-content/uploads/2023/06/ginee_20230622180630695_7892702895.png',
            'stok' => $stok,
            'slug' => $this->generateSlug($judul)
        ]);



        $serial = strtoupper(str_replace(' ', '-', $judul));

        for ($i = 0; $i < $stok; $i++)
        {
            DetailBuku::create([
                'buku_id' => 1,
                'status' => 'Tersedia',
                'serial_num' => "AR-BOOK-{$serial}-" . $i+1
            ]);
        }
    }
}
