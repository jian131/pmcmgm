<?php

namespace App\Http\Controllers;

use App\Models\HoaDon;
use App\Models\KhachHang;
use App\Models\NhanVien;
use Illuminate\Http\Request;

class HoaDonController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý,nhân viên']);
    }

    public function index()
    {
        $hoaDon = HoaDon::with(['khachHang', 'nhanVien'])->get();
        return view('hoadon.index', compact('hoaDon'));
    }

    public function create()
    {
        $khachHang = KhachHang::all();
        $nhanVien = NhanVien::all();
        return view('hoadon.create', compact('khachHang', 'nhanVien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NgayLap' => 'required|date',
            'MaKhachHang' => 'nullable|exists:KhachHang,MaKhachHang',
            'MaNhanVien' => 'nullable|exists:NhanVien,MaNhanVien',
        ]);

        HoaDon::create($request->all());

        return redirect()->route('hoadon.index')->with('success', 'Tạo hóa đơn thành công.');
    }

    public function show(HoaDon $hoadon)
    {
        $hoadon->load(['khachHang', 'nhanVien', 'chiTietHoaDon.thuoc']);
        return view('hoadon.show', compact('hoadon'));
    }

    public function edit(HoaDon $hoadon)
    {
        $khachHang = KhachHang::all();
        $nhanVien = NhanVien::all();
        return view('hoadon.edit', compact('hoadon', 'khachHang', 'nhanVien'));
    }

    public function update(Request $request, HoaDon $hoadon)
    {
        $request->validate([
            'NgayLap' => 'required|date',
            'MaKhachHang' => 'nullable|exists:KhachHang,MaKhachHang',
            'MaNhanVien' => 'nullable|exists:NhanVien,MaNhanVien',
        ]);

        $hoadon->update($request->all());

        return redirect()->route('hoadon.index')->with('success', 'Cập nhật hóa đơn thành công.');
    }

    public function destroy(HoaDon $hoadon)
    {
        $hoadon->delete();
        return redirect()->route('hoadon.index')->with('success', 'Xóa hóa đơn thành công.');
    }
}
