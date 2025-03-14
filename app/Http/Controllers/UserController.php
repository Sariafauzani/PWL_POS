<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index () {

       $user = UserModel::create(
        [
            'username' => 'manager55',
            'nama' => 'Manager55',
            'password' => Hash::make('12345'),
            'level_id' => 2
        ],
       );
       $user->username = 'manager56';

       $user->isDirty(); // true
       $user->isDirty('username'); // true
       $user->isDirty('name'); // false
       $user->isDirty(['nama', 'username']); // false
        
       $user->save();

       $user->isDirty(); // false
       $user->isDirty(); // true
       dd($user->isDirty());
    }
}
