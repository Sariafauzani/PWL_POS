<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data = [
            ['user_id' => 1, 'pembeli' => 'Andi', 'penjualan_kode' => 'TRX001', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Budi', 'penjualan_kode' => 'TRX002', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 3, 'pembeli' => 'Citra', 'penjualan_kode' => 'TRX003', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 1, 'pembeli' => 'Dewi', 'penjualan_kode' => 'TRX004', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Eka', 'penjualan_kode' => 'TRX005', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 3, 'pembeli' => 'Faisal', 'penjualan_kode' => 'TRX006', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 1, 'pembeli' => 'Gina', 'penjualan_kode' => 'TRX007', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 2, 'pembeli' => 'Hadi', 'penjualan_kode' => 'TRX008', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 3, 'pembeli' => 'Ira', 'penjualan_kode' => 'TRX009', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
            ['user_id' => 1, 'pembeli' => 'Joko', 'penjualan_kode' => 'TRX010', 'penjualan_tanggal' => now(), 'created_at' => NOW()],
        ];

        // Insert data ke dalam tabel t_penjualan
        DB::table('t_penjualan')->insert($data);
    }
}
