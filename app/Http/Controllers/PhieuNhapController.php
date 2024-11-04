<?php

namespace App\Http\Controllers;

use App\Models\PhieuNhap;
use App\Models\NhanVien;
use App\Models\Thuoc;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;

class PhieuNhapController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý,nhân viên']);
    }

    public function index()
    {
        $phieuNhap = PhieuNhap::with(['thuoc', 'nhaCungCap'])->get();
        return view('phieunhap.index', compact('phieuNhap'));
    }

    public function create()
    {
        $thuoc = Thuoc::all();
        $nhaCungCap = NhaCungCap::all();
        return view('phieunhap.create', compact('thuoc', 'nhaCungCap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'NgayNhap' => 'required|date',
            'MaThuoc' => 'required|exists:Thuoc,MaThuoc',
            'TenThuoc' => 'required|string|max:100',
            'SoLuong' => 'required|integer',
            'MaNhaCungCap' => 'required|exists:NhaCungCap,MaNhaCungCap',
        ]);

        PhieuNhap::create($request->all());

        return redirect()->route('phieunhap.index')->with('success', 'Tạo phiếu nhập thành công.');
    }

    public function show(PhieuNhap $phieunhap)
    {
        $phieunhap->load(['thuoc', 'nhaCungCap']);
        return view('phieunhap.show', compact('phieunhap'));
    }

    public function edit(PhieuNhap $phieunhap)
    {
        $thuoc = Thuoc::all();
        $nhaCungCap = NhaCungCap::all();
        return view('phieunhap.edit', compact('phieunhap', 'thuoc', 'nhaCungCap'));
    }

    public function update(Request $request, PhieuNhap $phieunhap)
    {
        $request->validate([
            'NgayNhap' => 'required|date',
            'MaThuoc' => 'required|exists:Thuoc,MaThuoc',
            'TenThuoc' => 'required|string|max:100',
            'SoLuong' => 'required|integer',
            'MaNhaCungCap' => 'required|exists:NhaCungCap,MaNhaCungCap',
        ]);

        $phieunhap->update($request->all());

        return redirect()->route('phieunhap.index')->with('success', 'Cập nhật phiếu nhập thành công.');
    }

    public function destroy(PhieuNhap $phieunhap)
    {
        $phieunhap->delete();
        return redirect()->route('phieunhap.index')->with('success', 'Xóa phiếu nhập thành công.');
    }
}
