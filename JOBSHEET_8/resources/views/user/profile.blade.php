@extends('layouts.template')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Profile User</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Kolom kiri: Foto profil dan form upload -->
            <div class="col-md-4 text-center mb-4">
                <!-- Menampilkan foto profil, jika tidak ada pakai default -->
                <img 
                    src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('img/default-profile.png') }}" 
                    class="img-circle elevation-2 mb-3 border border-primary" 
                    alt="User Image" 
                    style="width: 200px; height: 200px; object-fit: cover; padding: 5px; background: #f8f9fa;">
                
                <!-- Form upload foto -->
                <form 
                    action="{{ url('/user/update-photo') }}" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    class="mt-2">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="custom-file">
                                <input 
                                    type="file" 
                                    class="custom-file-input" 
                                    id="profile_photo" 
                                    name="profile_photo" 
                                    accept="image/*">
                                <label class="custom-file-label" for="profile_photo">Pilih Foto</label>
                            </div>
                        </div>
                        <!-- Menampilkan pesan error jika ada -->
                        @error('profile_photo')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Upload Foto</button>
                </form>
            </div>

            <!-- Kolom kanan: Data user -->
            <div class="col-md-8">
                <h4 class="mb-4">Data User</h4>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%" class="bg-light">Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Level</th>
                        <td>{{ $user->level->level_nama ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#profile_photo').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').html(fileName);

                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('img.img-circle').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush