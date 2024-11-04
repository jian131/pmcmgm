<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use Illuminate\Http\Request;

class KhachHangController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý']);
    }

    public function index()
    {
        $khachHang = KhachHang::all();
        return view('khachhang.index', compact('khachHang'));
    }

    public function create()
    {
        return view('khachhang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'TenKhachHang' => 'required|string|max:100',
            'SoDienThoai' => 'nullable|string|max:15',
            'DiaChi' => 'nullable|string|max:255',
        ]);

        KhachHang::create($request->all());

        return redirect()->route('khachhang.index')->with('success', 'Thêm khách hàng thành công.');
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
            'TenKhachHang' => 'required|string|max:100',
            'SoDienThoai' => 'nullable|string|max:15',
            'DiaChi' => 'nullable|string|max:255',
        ]);

        $khachHang->update($request->all());

        return redirect()->route('khachhang.index')->with('success', 'Cập nhật khách hàng thành công.');
    }

    public function destroy(KhachHang $khachHang)
    {
        $khachHang->delete();
        return redirect()->route('khachhang.index')->with('success', 'Xóa khách hàng thành công.');
    }
}
