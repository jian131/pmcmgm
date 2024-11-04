@extends('layouts.admin')

@section('title', 'Khách hàng')

@section('header', 'Danh sách Khách hàng')

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('khachhang.create') }}" class="btn btn-primary">Thêm Khách hàng</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mã KH</th>
                    <th>Tên Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Điểm tích lũy</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($khachHangs as $kh)
                <tr>
                    <td>{{ $kh->MaKhachHang }}</td>
                    <td>{{ $kh->TenKhachHang }}</td>
                    <td>{{ $kh->SoDienThoai }}</td>
                    <td>{{ $kh->DiaChi }}</td>
                    <td>{{ $kh->DiemTichLuy }}</td>
                    <td>
                        <a href="{{ route('khachhang.edit', $kh->MaKhachHang) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('khachhang.destroy', $kh->MaKhachHang) }}" method="POST" style="display:inline-block;">
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
