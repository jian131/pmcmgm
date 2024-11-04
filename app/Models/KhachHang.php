<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;

    protected $table = 'KhachHang';
    protected $primaryKey = 'MaKhachHang';
    public $timestamps = false;

    protected $fillable = [
        'TenKhachHang',
        'SoDienThoai',
        'DiaChi',
        'DiemTichLuy',
    ];

    public function hoaDons()
    {
        return $this->hasMany(HoaDon::class, 'MaKhachHang');
    }
}
