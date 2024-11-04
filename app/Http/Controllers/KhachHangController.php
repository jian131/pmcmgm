<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function index()
    {
        $khachHangs = KhachHang::all();
        return view('khachhang.index', compact('khachHangs'));
    }

    public function create()
    {
        return view('khachhang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenKhachHang' => 'required|string|max:255',
            'SoDienThoai' => 'required|unique:KhachHang,SoDienThoai',
            'DiaChi' => 'required|string',
            'DiemTichLuy' => 'required|integer|min:0',
        ]);

        KhachHang::create($request->all());

        return redirect()->route('khachhang.index')->with('success', 'Khách hàng được tạo thành công.');
    }

    public function show(KhachHang $khachHang)
    {
        return view('khachhang.show', compact('khachHang'));
    }

    public function edit(KhachHang $khachHang)
    {
        return view('khachhang.edit', compact('khachHang'));
    }

    public function update(Request $request, KhachHang $khachHang)
    {
        $request->validate([
            'TenKhachHang' => 'required|string|max:255',
            'SoDienThoai' => 'required|unique:KhachHang,SoDienThoai,' . $khachHang->MaKhachHang . ',MaKhachHang',
            'DiaChi' => 'required|string',
            'DiemTichLuy' => 'required|integer|min:0',
        ]);

        $khachHang->update($request->all());

        return redirect()->route('khachhang.index')->with('success', 'Khách hàng được cập nhật thành công.');
    }

    public function destroy(KhachHang $khachHang)
    {
        $khachHang->delete();
        return redirect()->route('khachhang.index')->with('success', 'Khách hàng được xóa thành công.');
    }
}
