<?php

namespace App\Http\Controllers;

use App\Models\PhieuThu;
use App\Models\HoaDon;
use Illuminate\Http\Request;

class PhieuThuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý,nhân viên']);
    }

    public function index()
    {
        $phieuThu = PhieuThu::with('hoaDon')->get();
        return view('phieuthu.index', compact('phieuThu'));
    }

    public function create()
    {
        $hoaDon = HoaDon::all();
        return view('phieuthu.create', compact('hoaDon'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaHoaDon' => 'required|exists:HoaDon,MaHoaDon',
            'NgayLap' => 'required|date',
            'NguoiLap' => 'nullable|string|max:100',
            'SoTien' => 'required|numeric',
        ]);

        PhieuThu::create($request->all());

        return redirect()->route('phieuthu.index')->with('success', 'Tạo phiếu thu thành công.');
    }

    public function show(PhieuThu $phieuthu)
    {
        $phieuthu->load('hoaDon');
        return view('phieuthu.show', compact('phieuthu'));
    }

    public function edit(PhieuThu $phieuthu)
    {
        $hoaDon = HoaDon::all();
        return view('phieuthu.edit', compact('phieuthu', 'hoaDon'));
    }

    public function update(Request $request, PhieuThu $phieuthu)
    {
        $request->validate([
            'MaHoaDon' => 'required|exists:HoaDon,MaHoaDon',
            'NgayLap' => 'required|date',
            'NguoiLap' => 'nullable|string|max:100',
            'SoTien' => 'required|numeric',
        ]);

        $phieuthu->update($request->all());

        return redirect()->route('phieuthu.index')->with('success', 'Cập nhật phiếu thu thành công.');
    }

    public function destroy(PhieuThu $phieuthu)
    {
        $phieuthu->delete();
        return redirect()->route('phieuthu.index')->with('success', 'Xóa phiếu thu thành công.');
    }
}
