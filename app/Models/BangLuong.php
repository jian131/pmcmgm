<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BangLuong extends Model
{
    use HasFactory;

    protected $table = 'BangLuong';
    protected $primaryKey = 'MaBangLuong';
    public $timestamps = false;

    protected $fillable = [
        'MaNhanVien',
        'Thang',
        'LuongCoBan',
        'ThuongChuyenCan',
        'ThuongKPI',
        'SoNgayNghi',
        'TongLuong',
    ];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien');
    }

    public function chiTietLuong()
    {
        return $this->hasMany(ChiTietLuong::class, 'MaBangLuong');
    }
}
