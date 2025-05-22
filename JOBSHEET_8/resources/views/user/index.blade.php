@extends('layouts.template')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar User</h3>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">Import Data User</button>
                <a href="{{ url('/user/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i>Export User</a>
                <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Export User</a>
                <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-success">Tambah Data (Ajax)</button>
            </div>
        </div>
        <div class="card-body">
            <!-- Untuk filter data -->
            <div id="filter" class="form-horizontal filter-date p-2 border-bottom mb-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm row text-sm mb-0">
                            <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                            <div class="col-md-3">
                                <select name="filter_kategori" class="form-control form-control-sm filter_kategori">
                                    <option value="">- Semua -</option>
                                    @foreach ($level as $item)
                                        <option value="{{$item->level_id}}">{{$item->level_nama}}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Level Pengguna</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <table class="table table-bordered table-striped table-hover table-sm" id="table-barang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Level Pengguna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>
    @endsection

    @push('js')
        <script>
            function modalAction(url = '') {
                $('#myModal').load(url, function() {
                    $('#myModal').modal('show');
                });
            }

            var tableUser;
            $(document).ready(function() {
                tableUser = $('#table-barang').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        "url": "{{ url('user/list') }}", // URL untuk request data
                        "dataType": "json",
                        "type": "POST",
                        "data": function(d) {
                            d.level_id = $('.filter_kategori').val(); 
                        }
                    },
                    columns: [{
                        // nomor urut dari laravel datatable addIndexColumn() 
                        data: "DT_RowIndex",
                        className: "text-center",
                        width: "5%",
                        orderable: false,
                        searchable: false
                    }, {
                        data: "username",
                        className: "",
                        width: "10%",
                        orderable: true, 
                        searchable: true
                    }, {
                        data: "nama",
                        className: "",
                        width: "37%",
                        orderable: true,
                        searchable: true
                    }, {
                        data: "level.level_nama",
                        className: "",
                        width: "34%",
                        orderable: true,
                        searchable: true,
                    }, {
                        data: "aksi",
                        className: "text-center",
                        width: "14%",
                        orderable: false,
                        searchable: false
                    }]
                });

                $('#table-barang_filter input').unbind().bind().on('keyup', function (e) {
                    if (e.keyCode == 13) { // enter key
                        tableUser.search(this.value).draw();
                    }
                });

                $('.filter_kategori').change(function () {
                    tableUser.draw();
                });
            });

        </script>
    @endpush
