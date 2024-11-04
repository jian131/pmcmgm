<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    protected $table = 'NhaCungCap';
    protected $primaryKey = 'MaNhaCungCap';
    public $timestamps = false;

    protected $fillable = [
        'TenNhaCungCap',
        'DiaChi',
        'SoDienThoai',
    ];

    public function phieuNhap()
    {
        return $this->hasMany(PhieuNhap::class, 'MaNhaCungCap');
    }
}
