<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Stok dari Supplier 1 (Elektronik)
            ['supplier_id' => 1, 'barang_id' => 1, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 50, 'created_at' => NOW()],
            ['supplier_id' => 1, 'barang_id' => 2, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 40, 'created_at' => NOW()],
            ['supplier_id' => 1, 'barang_id' => 3, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 30, 'created_at' => NOW()],
            ['supplier_id' => 1, 'barang_id' => 4, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 20, 'created_at' => NOW()],
            ['supplier_id' => 1, 'barang_id' => 5, 'user_id' => 1, 'stok_tanggal' => now(), 'stok_jumlah' => 25, 'created_at' => NOW()],

            // Stok dari Supplier 2 (Fashion)
            ['supplier_id' => 2, 'barang_id' => 6, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 80, 'created_at' => NOW()],
            ['supplier_id' => 2, 'barang_id' => 7, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 60, 'created_at' => NOW()],
            ['supplier_id' => 2, 'barang_id' => 8, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 45, 'created_at' => NOW()],
            ['supplier_id' => 2, 'barang_id' => 9, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 50, 'created_at' => NOW()],
            ['supplier_id' => 2, 'barang_id' => 10, 'user_id' => 2, 'stok_tanggal' => now(), 'stok_jumlah' => 30, 'created_at' => NOW()],

            // Stok dari Supplier 3 (Alat Tulis)
            ['supplier_id' => 3, 'barang_id' => 11, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 100, 'created_at' => NOW()],
            ['supplier_id' => 3, 'barang_id' => 12, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 120, 'created_at' => NOW()],
            ['supplier_id' => 3, 'barang_id' => 13, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 90, 'created_at' => NOW()],
            ['supplier_id' => 3, 'barang_id' => 14, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 85, 'created_at' => NOW()],
            ['supplier_id' => 3, 'barang_id' => 15, 'user_id' => 3, 'stok_tanggal' => now(), 'stok_jumlah' => 95, 'created_at' => NOW()],
        ];

        // Insert data ke dalam tabel t_stok
        DB::table('t_stok')->insert($data);
    }
}
