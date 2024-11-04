<?php

namespace App\Http\Controllers;

use App\Models\ChiTietLuong;
use App\Models\BangLuong;
use Illuminate\Http\Request;

class ChiTietLuongController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý']);
    }

    public function index()
    {
        $chiTietLuong = ChiTietLuong::with('bangLuong')->get();
        return view('chitietluong.index', compact('chiTietLuong'));
    }

    public function create()
    {
        $bangLuong = BangLuong::all();
        return view('chitietluong.create', compact('bangLuong'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MaBangLuong' => 'required|exists:BangLuong,MaBangLuong',
            'MoTa' => 'nullable|string|max:255',
            'SoTien' => 'required|numeric',
        ]);

        ChiTietLuong::create($request->all());

        return redirect()->route('chitietluong.index')->with('success', 'Thêm chi tiết lương thành công.');
    }

    public function show(ChiTietLuong $chitietluong)
    {
        return view('chitietluong.show', compact('chitietluong'));
    }

    public function edit(ChiTietLuong $chitietluong)
    {
        $bangLuong = BangLuong::all();
        return view('chitietluong.edit', compact('chitietluong', 'bangLuong'));
    }

    public function update(Request $request, ChiTietLuong $chitietluong)
    {
        $request->validate([
            'MaBangLuong' => 'required|exists:BangLuong,MaBangLuong',
            'MoTa' => 'nullable|string|max:255',
            'SoTien' => 'required|numeric',
        ]);

        $chitietluong->update($request->all());

        return redirect()->route('chitietluong.index')->with('success', 'Cập nhật chi tiết lương thành công.');
    }

    public function destroy(ChiTietLuong $chitietluong)
    {
        $chitietluong->delete();
        return redirect()->route('chitietluong.index')->with('success', 'Xóa chi tiết lương thành công.');
    }
}
