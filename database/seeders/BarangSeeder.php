<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $sekarang = now();

        $barang = [
            ['nama' => 'Buku Tulis', 'harga' => 5000, 'stok' => 30],
            ['nama' => 'Pulpen', 'harga' => 3000, 'stok' => 50],
            ['nama' => 'Pensil', 'harga' => 2000, 'stok' => 40],
            ['nama' => 'Penghapus', 'harga' => 1500, 'stok' => 25],
            ['nama' => 'Penggaris', 'harga' => 4000, 'stok' => 20],
        ];

        foreach ($barang as $item) {
            DB::table('barang')->updateOrInsert(
                ['nama' => $item['nama']],
                array_merge($item, [
                    'created_at' => $sekarang,
                    'updated_at' => $sekarang,
                ])
            );
        }
    }
}
