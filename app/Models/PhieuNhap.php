<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'PhieuNhap';
    protected $primaryKey = 'MaPhieuNhap';
    public $timestamps = false;

    protected $fillable = [
        'MaNhaCungCap',
        'NgayNhap',
        'MaNhanVien',
        'SoLuong',
        'TongTien',
    ];

    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap');
    }

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'MaNhanVien');
    }
}
