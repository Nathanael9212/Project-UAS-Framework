<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusans = [
            [
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'kode_jurusan' => 'TKJ',
            ],
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'kode_jurusan' => 'RPL',
            ],
            [
                'nama_jurusan' => 'Multimedia',
                'kode_jurusan' => 'MM',
            ],
            [
                'nama_jurusan' => 'Teknik Kendaraan Ringan',
                'kode_jurusan' => 'TKR',
            ],
            [
                'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga',
                'kode_jurusan' => 'AKL',
            ],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::create($jurusan);
        }
    }
}
