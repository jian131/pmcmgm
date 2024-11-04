<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuThu extends Model
{
    use HasFactory;

    protected $table = 'PhieuThu';
    protected $primaryKey = 'MaPhieuThu';
    public $timestamps = false;

    protected $fillable = [
        'MaHoaDon',
        'NgayLap',
        'NguoiLap',
        'SoTien',
    ];

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'MaHoaDon');
    }

    public function khachHang()
    {
        return $this->belongsTo(KhachHang::class, 'MaKhachHang');
    }
}
