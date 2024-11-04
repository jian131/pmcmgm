<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thuoc extends Model
{
    use HasFactory;

    protected $table = 'Thuoc';
    protected $primaryKey = 'MaThuoc';
    public $timestamps = false;

    protected $fillable = [
        'TenThuoc',
        'NhomLoaiThuoc',
        'HangSanXuat',
        'HanSuDung',
        'SoLuong',
        'Gia',
    ];

    public function chiTietHoaDons()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'MaThuoc');
    }
}
