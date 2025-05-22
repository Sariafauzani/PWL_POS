<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierModel;
use App\Models\LevelModel;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier Barang',
            'list' => ['Home', 'Supplier'],
        ];

        $page = (object) [
            'title' => 'Daftar Supplier Barang yang terdaftar dalam sistem',
        ];

        $activeMenu = 'supplier';
        $supplier = SupplierModel::all();

        return view('supplier.index', ['breadcrumb' => $breadcrumb,  'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
    }
    // Ambil data supplier dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        //Filter data berdasarkan supplier_id
        if ($request->supplier_id) {
            $suppliers->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($suppliers)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/supplier/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/supplier/' . $supplier->supplier_id) . '">'
                    . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
                         confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';

                $btn = '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/supplier/' . $supplier->supplier_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan halaman form tambah supplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah supplier',
            'list' => ['Home', 'supplier', 'Tambah'],
        ];

        $page = (object) [
            'title' => 'Tambah supplier Baru',
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page]);
    }

    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')->get();

        return view('supplier.create_ajax')
            ->with('supplier', $supplier);
    }


    //Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode'     => 'required|string|max:10|unique:m_supplier,supplier_kode',
            'supplier_nama'     => 'required|string|max:100',
            'supplier_alamat'   => 'required|string|max:255',
        ]);

        SupplierModel::create([
            'supplier_kode'   => $request->supplier_kode,
            'supplier_nama'   => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil disimpan');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode'   => 'required|string|max:10|unique:m_supplier,supplier_kode',
                'supplier_nama'   => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:255',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            SupplierModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan',
            ]);
        }
        return redirect('/');
    }

    public function show(string $id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail supplier',
            'list' => ['Home', 'supplier', 'Detail'],
        ];

        $page = (object) [
            'title' => 'Detail supplier',
        ];

        $activeMenu = 'supplier';

        return view('supplier.show', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'page' => $page,
            'supplier' => $supplier
        ]);
    }

    public function edit(string $id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit supplier',
            'list' => ['Home', 'supplier', 'Edit'],
        ];

        $page = (object) [
            'title' => 'Edit supplier',
        ];

        $activeMenu = 'supplier';

        return view('supplier.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'page' => $page, 'supplier' => $supplier]);
    }

    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_kode'   => 'required|string|max:10',
            'supplier_nama'   => 'required|string|max:100',
            'supplier_alamat' => 'required|string|max:255',
        ]);

        SupplierModel::find($id)->update([
            'supplier_kode'   => $request->supplier_kode,
            'supplier_nama'   => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }

    public function update_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode'   => 'required|string|max:10',
                'supplier_nama'   => 'required|string|max:100',
                'supplier_alamat' => 'required|string|max:255',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }
            $check = SupplierModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data supplier berhasil diubah',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data supplier tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);

            if ($supplier) {
                $supplier->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function destroy(string $id)
    {
        $check = SupplierModel::find($id);
        if (!$check) {
            return redirect('/supplier')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            SupplierModel::destroy($id);

            return redirect('/supplier')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/supplier')->with('error', 'Data supplier gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function import()
    {
        return view('supplier.import');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_supplier' => ['required', 'mimes:xlsx', 'max:1024'], // validasi file
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_supplier');
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $insert[] = [
                            'supplier_kode' => $value['A'],
                            'supplier_nama' => $value['B'],
                            'supplier_alamat' => $value['C'],
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    SupplierModel::insertOrIgnore($insert);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport',
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel() {
        // ambil data supplier yang akan di export
        $supplier = SupplierModel::select('supplier_kode', 'supplier_nama', 'supplier_alamat')
                    ->get();

        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();  // ambil sheet yang aktif

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Supplier');
        $sheet->setCellValue('C1', 'Nama Supplier');
        $sheet->setCellValue('D1', 'Alamat Supplier');

        $sheet->getStyle('A1:D1')->getFont()->setBold(true);  // bold header

        $no = 1;        // nomor data dimulai dari 1
        $baris = 2;     // baris data dimulai dari baris ke 2
        foreach ($supplier as $item) {
            $sheet->setCellValue('A'.$baris, $no);
            $sheet->setCellValue('B'.$baris, $item->supplier_kode);
            $sheet->setCellValue('C'.$baris, $item->supplier_nama);
            $sheet->setCellValue('D'.$baris, $item->supplier_alamat);
            $baris++;
            $no++;
        }
        
        foreach(range('A','D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Supplier '.date('Y-m-d H:i:s').'.xlsx';

        header('Conrent-Type: application/vnd,openxmlformats-officedocument.spreadsheet.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    } // end function export_excel
}
