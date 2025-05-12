<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home 
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }

        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

       // Menampilkan halaman register
       public function register()
       {
           $level = LevelModel::all();
           return view('auth.register', compact('level'));
       }
   
       // Menyimpan data register ke database
       public function postregister(Request $request)
       {
           if ($request->ajax() || $request->wantsJson()) {
               // Validasi input termasuk level_id
               $validator = Validator::make($request->all(), [
                   'username' => 'required|string|unique:m_user,username',
                   'nama' => 'required|string|max:100',
                   'password' => 'required|min:6',
                   'level_id' => 'required|in:1,2,3,4', // Validasi level_id, pastikan memilih dari 1 hingga 4
               ]);
               
               if ($validator->fails()) {
                   return response()->json([
                       'status' => false,
                       'message' => 'Validasi Gagal',
                       'msgField' => $validator->errors()
                   ]);
               }
   
               // Simpan ke database, termasuk level_id
               UserModel::create([
                   'username' => $request->username,
                   'nama' => $request->nama,
                   'password' => Hash::make($request->password),
                   'level_id' => $request->level_id, // Simpan level_id
               ]);
   
               return response()->json([
                   'status' => true,
                   'message' => 'Registrasi Berhasil',
                   'redirect' => url('login'),
                   'level_id' => $request->level_id, // Simpan level_id yang dipilih untuk dikirimkan dalam respons
               ]);
           }
   
           return redirect('register');
       }
}
