<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;

class NhanVienController extends Controller
{
    public function index()
    {
        $nhanViens = NhanVien::all();
        return view('nhanvien.index', compact('nhanViens'));
    }

    public function create()
    {
        return view('nhanvien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'HoTen' => 'required|string|max:255',
            'NgaySinh' => 'required|date',
            'DiaChi' => 'required|string',
            'SoDienThoai' => 'required|unique:NhanVien,SoDienThoai',
        ]);

        NhanVien::create($request->all());

        return redirect()->route('nhanvien.index')->with('success', 'Nhân viên được tạo thành công.');
    }

    public function show(NhanVien $nhanVien)
    {
        return view('nhanvien.show', compact('nhanVien'));
    }

    public function edit(NhanVien $nhanVien)
    {
        return view('nhanvien.edit', compact('nhanVien'));
    }

    public function update(Request $request, NhanVien $nhanVien)
    {
        $request->validate([
            'HoTen' => 'required|string|max:255',
            'NgaySinh' => 'required|date',
            'DiaChi' => 'required|string',
            'SoDienThoai' => 'required|unique:NhanVien,SoDienThoai,' . $nhanVien->MaNhanVien . ',MaNhanVien',
        ]);

        $nhanVien->update($request->all());

        return redirect()->route('nhanvien.index')->with('success', 'Nhân viên được cập nhật thành công.');
    }

    public function destroy(NhanVien $nhanVien)
    {
        $nhanVien->delete();
        return redirect()->route('nhanvien.index')->with('success', 'Nhân viên được xóa thành công.');
    }
}
