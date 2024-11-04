<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietLuong extends Model
{
    use HasFactory;

    protected $table = 'ChiTietLuong';
    protected $primaryKey = 'id'; // Assuming there's an 'id' column
    public $timestamps = false;

    protected $fillable = [
        'MaBangLuong',
        'MoTa',
        'SoTien',
    ];

    public function bangLuong()
    {
        return $this->belongsTo(BangLuong::class, 'MaBangLuong');
    }
}
