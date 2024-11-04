<?php

namespace App\Http\Controllers;

use App\Models\BangLuong;
use App\Models\NhanVien;
use Illuminate\Http\Request;

class BangLuongController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý']);
    }

    public function index()
    {
        $bangLuong = BangLuong::with('nhanVien')->get();
        return view('bangluong.index', compact('bangLuong'));
    }

    public function create()
    {
        $nhanVien = NhanVien::all();
        return view('bangluong.create', compact('nhanVien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaNhanVien' => 'required|exists:NhanVien,MaNhanVien',
            'Thang' => 'required|date',
            'LuongCoBan' => 'required|numeric',
            'ThuongChuyenCan' => 'nullable|numeric',
            'ThuongKPI' => 'nullable|numeric',
            'SoNgayNghi' => 'nullable|integer',
            'TongLuong' => 'required|numeric',
        ]);

        BangLuong::create($request->all());

        return redirect()->route('bangluong.index')->with('success', 'Tạo bảng lương thành công.');
    }

    public function show(BangLuong $bangluong)
    {
        $bangluong->load('chiTietLuong');
        return view('bangluong.show', compact('bangluong'));
    }

    public function edit(BangLuong $bangluong)
    {
        $nhanVien = NhanVien::all();
        return view('bangluong.edit', compact('bangluong', 'nhanVien'));
    }

    public function update(Request $request, BangLuong $bangluong)
    {
        $request->validate([
            'MaNhanVien' => 'required|exists:NhanVien,MaNhanVien',
            'Thang' => 'required|date',
            'LuongCoBan' => 'required|numeric',
            'ThuongChuyenCan' => 'nullable|numeric',
            'ThuongKPI' => 'nullable|numeric',
            'SoNgayNghi' => 'nullable|integer',
            'TongLuong' => 'required|numeric',
        ]);

        $bangluong->update($request->all());

        return redirect()->route('bangluong.index')->with('success', 'Cập nhật bảng lương thành công.');
    }

    public function destroy(BangLuong $bangluong)
    {
        $bangluong->delete();
        return redirect()->route('bangluong.index')->with('success', 'Xóa bảng lương thành công.');
    }
}
