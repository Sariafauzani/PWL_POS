<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index () {

       $user = UserModel::all();
       return view('user', ['data' => $user]);
    }

    public function tambah() {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request) {
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);

        return redirect('/user');
    }

    public function ubah($id) {
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan($id, Request $request) {
        $user = UserModel::findOrFail($id);

        $request->validate([
            'nama' => 'required|string',
            'username' => 'required|string|unique:m_user,username,' .$id. ',user_id',
            'password' => 'nullable|min:6',
            'level_id' => 'required|integer',
        ]);

        $user->username = $request->username;
        $user->nama = $request->nama;
        
        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->level_id = $request->level_id;

        $user->save();

        return redirect('/user')->with('success', 'Data berhasil diperbarui!');

    }

    public function hapus($id) {
        $user = UserModel::find($id);
        $user->delete();

        return redirect('/user');
    }
}
