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
        'NgayNhap',
        'MaThuoc',
        'TenThuoc',
        'SoLuong',
        'MaNhaCungCap',
    ];

    public function thuoc()
    {
        return $this->belongsTo(Thuoc::class, 'MaThuoc');
    }

    public function nhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'MaNhaCungCap');
    }
}
