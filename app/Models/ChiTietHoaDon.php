<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;

    protected $table = 'ChiTietHoaDon';
    public $timestamps = false;

    protected $primaryKey = ['MaHoaDon', 'MaThuoc'];
    public $incrementing = false;

    protected $fillable = [
        'MaHoaDon',
        'MaThuoc',
        'SoLuong',
        'ThanhTien',
    ];

    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'MaHoaDon');
    }

    public function thuoc()
    {
        return $this->belongsTo(Thuoc::class, 'MaThuoc');
    }
}
