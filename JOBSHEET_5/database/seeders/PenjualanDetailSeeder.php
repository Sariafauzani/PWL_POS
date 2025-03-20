<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        // 10 transaksi, masing-masing 3 barang (total 30 data)
        for ($penjualan_id = 1; $penjualan_id <= 10; $penjualan_id++) {
            $data[] = ['penjualan_id' => $penjualan_id, 'barang_id' => 1, 'harga' => 7000000, 'jumlah' => 1, 'created_at' => NOW()];
            $data[] = ['penjualan_id' => $penjualan_id, 'barang_id' => 2, 'harga' => 4500000, 'jumlah' => 1, 'created_at' => NOW()];
            $data[] = ['penjualan_id' => $penjualan_id, 'barang_id' => 3, 'harga' => 300000, 'jumlah' => 2, 'created_at' => NOW()];
        }

        // Insert data ke dalam tabel t_penjualan_detail
        DB::table('t_penjualan_detail')->insert($data);
    }
}
