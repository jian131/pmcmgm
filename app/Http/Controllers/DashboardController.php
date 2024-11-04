<?php

namespace App\Http\Controllers;

use App\Models\KhachHang;
use App\Models\Thuoc;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use App\Models\NhanVien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $myOrders = 0;

        // Common Data
        $totalCustomers = KhachHang::count();
        $totalMedicines = Thuoc::count();
        $lowStockCount = Thuoc::where('SoLuong', '<', 50)->count();

        // Revenue for the Current Month
        $currentMonthSales = HoaDon::whereMonth('NgayLap', now()->month)
            ->whereYear('NgayLap', now()->year)
            ->join('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->sum('ChiTietHoaDon.ThanhTien');

        // Monthly Sales (Last 6 Months)
        $monthlySales = HoaDon::select(
            DB::raw('MONTH(NgayLap) as month'),
            DB::raw('YEAR(NgayLap) as year'),
            DB::raw('SUM(ChiTietHoaDon.ThanhTien) as total')
        )
            ->join('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->whereBetween('NgayLap', [Carbon::create(2024, 8, 25), Carbon::create(2024, 11, 5)])
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $monthlyLabels = [];
        $monthlySalesData = [];
        foreach ($monthlySales as $data) {
            $monthlyLabels[] = "Tháng {$data->month}/{$data->year}";
            $monthlySalesData[] = $data->total;
        }

        // Top 5 Best-Selling Products
        $topProducts = ChiTietHoaDon::select(
            'Thuoc.TenThuoc',
            DB::raw('SUM(ChiTietHoaDon.SoLuong) as total_quantity')
        )
            ->join('Thuoc', 'ChiTietHoaDon.MaThuoc', '=', 'Thuoc.MaThuoc')
            ->groupBy('Thuoc.MaThuoc', 'Thuoc.TenThuoc')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        $topProductLabels = $topProducts->pluck('TenThuoc')->toArray();
        $topProductQuantities = $topProducts->pluck('total_quantity')->toArray();

        // Recent Transactions (Last 5)
        $recentTransactions = HoaDon::with(['khachHang'])
            ->select(
                'HoaDon.MaHoaDon',
                'HoaDon.NgayLap',
                'HoaDon.MaKhachHang',
                'HoaDon.MaNhanVien',
                DB::raw('SUM(ChiTietHoaDon.ThanhTien) as TongTien')
            )
            ->join('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
            ->groupBy('HoaDon.MaHoaDon', 'HoaDon.NgayLap', 'HoaDon.MaKhachHang', 'HoaDon.MaNhanVien')
            ->orderByDesc('HoaDon.NgayLap')
            ->limit(5)
            ->get();

        // Additional Data for Admin and Employees
        if ($user->hasRole('quản lý')) {
            $totalEmployees = NhanVien::count();
            $totalRevenue = HoaDon::join('ChiTietHoaDon', 'HoaDon.MaHoaDon', '=', 'ChiTietHoaDon.MaHoaDon')
                ->sum('ChiTietHoaDon.ThanhTien');
        }

        if ($user->hasRole('nhân viên')) {
            $myOrders = HoaDon::where('MaNhanVien', $user->MaNhanVien)->count();
        }

        return view('dashboard', compact(
            'totalCustomers',
            'totalMedicines',
            'lowStockCount',
            'currentMonthSales',
            'monthlyLabels',
            'monthlySalesData',
            'topProductLabels',
            'topProductQuantities',
            'recentTransactions',
            'totalEmployees',
            'totalRevenue',
            'myOrders'
        ));
    }
}
