<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;

    protected $table = 'ChiTietHoaDon';
    protected $primaryKey = 'id'; // Assuming there's an 'id' column
    public $timestamps = false;

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
