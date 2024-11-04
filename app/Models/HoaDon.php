<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'HoaDon';
    protected $primaryKey = 'MaHoaDon';
    public $timestamps = false;

    protected $fillable = [
        'NgayLap',
        'MaKhachHang',
        'MaNhanVien',
    ];

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKhachHang');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien');
    }

    public function chiTietHoaDons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'MaHoaDon');
    }

    public function phieuThu()
    {
        return $this->hasOne(PhieuThu::class, 'MaHoaDon');
    }
}
