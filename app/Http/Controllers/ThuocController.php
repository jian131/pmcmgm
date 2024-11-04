<?php

namespace App\Http\Controllers;

use App\Models\Thuoc;
use Illuminate\Http\Request;

class ThuocController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:quản lý,nhân viên']);
    }

    public function index()
    {
        $thuoc = Thuoc::all();
        return view('thuoc.index', compact('thuoc'));
    }

    public function create()
    {
        $this->authorize('create', Thuoc::class);
        return view('thuoc.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Thuoc::class);

        $request->validate([
            'TenThuoc' => 'required|string|max:100',
            'NhomLoaiThuoc' => 'nullable|string|max:50',
            'HangSanXuat' => 'nullable|string|max:100',
            'HanSuDung' => 'nullable|date',
            'SoLuong' => 'nullable|integer',
            'Gia' => 'nullable|numeric',
        ]);

        Thuoc::create($request->all());

        return redirect()->route('thuoc.index')->with('success', 'Thêm thuốc thành công.');
    }

    public function show(Thuoc $thuoc)
    {
        return view('thuoc.show', compact('thuoc'));
    }

    public function edit(Thuoc $thuoc)
    {
        $this->authorize('update', $thuoc);
        return view('thuoc.edit', compact('thuoc'));
    }

    public function update(Request $request, Thuoc $thuoc)
    {
        $this->authorize('update', $thuoc);

        $request->validate([
            'TenThuoc' => 'required|string|max:100',
            'NhomLoaiThuoc' => 'nullable|string|max:50',
            'HangSanXuat' => 'nullable|string|max:100',
            'HanSuDung' => 'nullable|date',
            'SoLuong' => 'nullable|integer',
            'Gia' => 'nullable|numeric',
        ]);

        $thuoc->update($request->all());

        return redirect()->route('thuoc.index')->with('success', 'Cập nhật thuốc thành công.');
    }

    public function destroy(Thuoc $thuoc)
    {
        $this->authorize('delete', $thuoc);
        $thuoc->delete();
        return redirect()->route('thuoc.index')->with('success', 'Xóa thuốc thành công.');
    }
}
