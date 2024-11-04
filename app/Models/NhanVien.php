<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;

    protected $table = 'NhanVien';
    protected $primaryKey = 'MaNhanVien';
    public $timestamps = false;

    protected $fillable = [
        'HoTen',
        'NgaySinh',
        'DiaChi',
        'SoDienThoai',
    ];

    public function hoaDon()
    {
        return $this->hasMany(HoaDon::class, 'MaNhanVien');
    }

    public function bangLuong()
    {
        return $this->hasMany(BangLuong::class, 'MaNhanVien');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'MaNhanVien');
    }
}
