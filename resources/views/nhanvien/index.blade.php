@extends('layouts.admin')

@section('title', 'Nhân viên')

@section('header', 'Danh sách Nhân viên')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('nhanvien.create') }}" class="btn btn-primary">Thêm Nhân viên</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Họ tên</th>
                    <th>Ngày sinh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Tài khoản</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nhanViens as $nv)
                <tr>
                    <td>{{ $nv->MaNhanVien }}</td>
                    <td>{{ $nv->HoTen }}</td>
                    <td>{{ \Carbon\Carbon::parse($nv->NgaySinh)->format('d/m/Y') }}</td>
                    <td>{{ $nv->DiaChi }}</td>
                    <td>{{ $nv->SoDienThoai }}</td>
                    <td>
                        @if($nv->user)
                            {{ $nv->user->email }}
                        @else
                            Chưa có tài khoản
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('nhanvien.edit', $nv->MaNhanVien) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('nhanvien.destroy', $nv->MaNhanVien) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
