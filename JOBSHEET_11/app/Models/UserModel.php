<?php

namespace App\Models;

use Attribute as GlobalAttribute;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable; // implementasi class Autheticatable
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Casts\Attribute;


class UserModel extends Authenticatable implements JWTSubject
{
    //use HasFactory;
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    protected $table = 'm_user'; // Mendefinisikan nama tabel yang digunakan oleh model ini
    protected $primaryKey = 'user_id'; // Mendefinisikan primary key dari tabel yang digunakan
    /**
     * The attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = ['username', 'password', 'nama', 'level_id', 'created_at', 'updated_at', 'profile_photo'];
    protected $hidden = ['password']; // jangan di tampilkan saat select

    protected $casts = ['password' => 'hashed']; // casting password agar otomatis di hash

    /**
     * Relasi ke tabel level
    */
    public function level(): BelongsTo {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }

    protected function profilePhoto(): Attribute
    {
        return Attribute::make(
            get: fn($profile_photo) => url('/storage/posts/' .$profile_photo),
        );
    }

    /**
     * Mendapatkan nama role
     */
    public function getRoleName(): string{
        return $this->level->level_nama;
    }

    /**
     * Cek apakah user memiliki role tertentu
     */
    public function hasRole($role): bool{
        return $this->level->level_kode == $role;
    }

    /**
     * Mendapatkan kode role
     */
    public function getRole() {
        return $this->level->level_kode;
    }
}
