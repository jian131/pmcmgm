<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;

class NhanVienController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý']);
    }

    public function index()
    {
        $nhanVien = NhanVien::all();
        return view('nhanvien.index', compact('nhanVien'));
    }

    public function create()
    {
        return view('nhanvien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'HoTen' => 'required|string|max:100',
            'NgaySinh' => 'nullable|date',
            'DiaChi' => 'nullable|string|max:255',
            'SoDienThoai' => 'nullable|string|max:15',
        ]);

        NhanVien::create($request->all());

        return redirect()->route('nhanvien.index')->with('success', 'Thêm nhân viên thành công.');
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
            'HoTen' => 'required|string|max:100',
            'NgaySinh' => 'nullable|date',
            'DiaChi' => 'nullable|string|max:255',
            'SoDienThoai' => 'nullable|string|max:15',
        ]);

        $nhanVien->update($request->all());

        return redirect()->route('nhanvien.index')->with('success', 'Cập nhật nhân viên thành công.');
    }

    public function destroy(NhanVien $nhanVien)
    {
        $nhanVien->delete();
        return redirect()->route('nhanvien.index')->with('success', 'Xóa nhân viên thành công.');
    }
}
