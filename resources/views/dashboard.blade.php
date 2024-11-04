@extends('layouts.admin')

@section('title', 'Dashboard')

@section('header', 'Tổng quan')

@section('content')
<div class="row">
    <!-- Customers Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalCustomers ?? 0 }}</h3>
                <p>Khách hàng</p>
            </div>
            <div class="icon">
                <i class="bi bi-people"></i>
            </div>
            <a href="{{ route('khachhang.index') }}" class="small-box-footer">
                Chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>

    <!-- Medicines Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalMedicines ?? 0 }}</h3>
                <p>Thuốc</p>
            </div>
            <div class="icon">
                <i class="bi bi-capsule"></i>
            </div>
            <a href="{{ route('thuoc.index') }}" class="small-box-footer">
                Chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>

    <!-- Sales Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($currentMonthSales ?? 0) }}đ</h3>
                <p>Doanh thu tháng</p>
            </div>
            <div class="icon">
                <i class="bi bi-graph-up"></i>
            </div>
            <a href="#" class="small-box-footer">
                Tổng doanh thu <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>

    <!-- Low Stock Widget -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $lowStockCount ?? 0 }}</h3>
                <p>Hết hàng</p>
            </div>
            <div class="icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <a href="{{ route('thuoc.index', ['stock' => 'low']) }}" class="small-box-footer">
                Chi tiết <i class="bi bi-arrow-right-circle"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Transactions -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Giao dịch gần đây</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mã HD</th>
                                <th>Khách hàng</th>
                                <th>Ngày</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions ?? [] as $transaction)
                            <tr>
                                <td>HD{{ $transaction->MaHoaDon }}</td>
                                <td>{{ $transaction->khachHang->TenKhachHang }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->NgayLap)->format('d/m/Y') }}</td>
                                <td>{{ number_format($transaction->TongTien) }}đ</td>
                                <td>
                                    <span class="badge bg-success">Hoàn thành</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có giao dịch nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions (Admin Only) -->
    @role('quản lý')
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thao tác nhanh</h3>
            </div>
            <div class="card-body">
                <a href="{{ route('hoadon.create') }}" class="btn btn-primary btn-block mb-3">
                    <i class="bi bi-plus-circle me-2"></i> Tạo hóa đơn mới
                </a>
                <a href="{{ route('khachhang.create') }}" class="btn btn-info btn-block mb-3">
                    <i class="bi bi-person-plus me-2"></i> Thêm khách hàng
                </a>
                <a href="{{ route('nhanvien.create') }}" class="btn btn-warning btn-block mb-3">
                    <i class="bi bi-person-plus-fill me-2"></i> Thêm nhân viên
                </a>
                <a href="{{ route('phieunhap.create') }}" class="btn btn-success btn-block mb-3">
                    <i class="bi bi-box-arrow-in-down me-2"></i> Tạo phiếu nhập
                </a>
                <a href="{{ route('bangluong.index') }}" class="btn btn-secondary btn-block">
                    <i class="bi bi-cash-stack me-2"></i> Quản lý lương
                </a>
            </div>
        </div>
    </div>
    @endrole
</div>

<div class="row">
    <!-- Charts Row -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Doanh thu theo tháng</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" style="min-height: 250px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Top sản phẩm bán chạy</h3>
            </div>
            <div class="card-body">
                <canvas id="productsChart" style="min-height: 250px"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($monthlySalesData) !!},
                borderColor: 'rgb(75, 192, 192)',
                fill: false,
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Doanh thu theo tháng'
                }
            }
        }
    });

    // Products Chart
    const productsCtx = document.getElementById('productsChart').getContext('2d');
    new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topProductLabels ?? []) !!},
            datasets: [{
                label: 'Số lượng bán',
                data: {!! json_encode($topProductQuantities ?? []) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Top 5 Sản phẩm bán chạy'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
