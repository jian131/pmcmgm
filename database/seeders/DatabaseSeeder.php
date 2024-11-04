<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class, // Ensure you have a PermissionSeeder
        ]);

        $faker = Faker::create('vi_VN');

        // Define the date range
        $startDate = Carbon::create(2024, 8, 25);
        $endDate = Carbon::create(2024, 11, 5);

        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign role using Spatie method
        $admin->assignRole('quản lý');

        // Seed KhachHang (Customers)
        $khachHangIds = [];
        for ($i = 1; $i <= 50; $i++) {
            $khachHangId = DB::table('KhachHang')->insertGetId([
                'TenKhachHang' => $faker->name,
                'SoDienThoai' => $faker->unique()->numerify('0#########'),
                'DiaChi' => $faker->address,
                'DiemTichLuy' => $faker->numberBetween(0, 5000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $khachHangIds[] = $khachHangId;
        }

        // Seed NhanVien (Employees)
        $nhanVienIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $nhanVienId = DB::table('NhanVien')->insertGetId([
                'HoTen' => $faker->name,
                'NgaySinh' => $faker->dateTimeBetween('-40 years', '-20 years'),
                'DiaChi' => $faker->address,
                'SoDienThoai' => $faker->unique()->numerify('0#########'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $nhanVienIds[] = $nhanVienId;
        }

        // Seed User for each NhanVien
        foreach ($nhanVienIds as $nhanVienId) {
            // Retrieve NhanVien details
            $nhanVien = DB::table('NhanVien')->where('MaNhanVien', $nhanVienId)->first();

            // Generate unique email based on name and ID
            $email = strtolower(str_replace(' ', '.', $nhanVien->HoTen)) . $nhanVienId . '@example.com';

            // Check if User already exists
            $user = DB::table('users')->where('email', $email)->first();

            if (!$user) {
                // Create new User
                $userId = DB::table('users')->insertGetId([
                    'name' => $nhanVien->HoTen,
                    'email' => $email,
                    'password' => Hash::make('password'), // Default password
                    'MaNhanVien' => $nhanVienId, // Link to NhanVien
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Assign 'nhân viên' role to User
                $nhanVienRole = Role::where('name', 'nhân viên')->first();
                DB::table('model_has_roles')->updateOrInsert(
                    [
                        'model_id' => $userId,
                        'model_type' => 'App\Models\User',
                    ],
                    [
                        'role_id' => $nhanVienRole->id,
                    ]
                );
            }
        }

        // Seed other tables: Thuoc, HoaDon, ChiTietHoaDon, PhieuThu, NhaCungCap, PhieuNhap, BangLuong, ChiTietLuong...
        // Example: Seed Thuoc (Medicines)
        $nhomThuoc = [
            'Kháng sinh' => ['Amoxicillin', 'Cephalexin', 'Azithromycin', 'Ciprofloxacin'],
            'Giảm đau' => ['Paracetamol', 'Ibuprofen', 'Meloxicam', 'Diclofenac'],
            'Tim mạch' => ['Amlodipine', 'Losartan', 'Bisoprolol', 'Aspirin'],
            'Dạ dày' => ['Omeprazole', 'Pantoprazole', 'Famotidine', 'Metoclopramide'],
            'Vitamin' => ['Vitamin C', 'Vitamin D3', 'Vitamin B Complex', 'Calcium']
        ];

        $thuocIds = [];
        foreach ($nhomThuoc as $nhom => $danhSachThuoc) {
            foreach ($danhSachThuoc as $tenThuoc) {
                $thuocIds[] = DB::table('Thuoc')->insertGetId([
                    'TenThuoc' => $tenThuoc,
                    'NhomLoaiThuoc' => $nhom,
                    'HangSanXuat' => $faker->randomElement(['DHG', 'Traphaco', 'Pymepharco', 'Imexpharm']),
                    'HanSuDung' => $faker->dateTimeBetween('+1 year', '+3 years'),
                    'SoLuong' => $faker->numberBetween(100, 1000),
                    'Gia' => $faker->randomElement([15000, 25000, 35000, 50000, 75000, 100000, 150000]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Seed HoaDon (Invoices) and ChiTietHoaDon (Invoice Details)
        for ($i = 1; $i <= 200; $i++) {
            $ngayLap = $faker->dateTimeBetween($startDate, $endDate);

            $hoaDonId = DB::table('HoaDon')->insertGetId([
                'NgayLap' => $ngayLap,
                'MaKhachHang' => $faker->randomElement($khachHangIds),
                'MaNhanVien' => $faker->randomElement($nhanVienIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2-5 products per invoice
            $soSanPham = $faker->numberBetween(2, 5);
            $thuocDaChon = [];

            for ($j = 0; $j < $soSanPham; $j++) {
                $maThuoc = $faker->randomElement($thuocIds);
                if (!in_array($maThuoc, $thuocDaChon)) {
                    $thuocDaChon[] = $maThuoc;
                    $soLuong = $faker->numberBetween(1, 5);
                    $thuoc = DB::table('Thuoc')->where('MaThuoc', $maThuoc)->first();
                    $thanhTien = $soLuong * $thuoc->Gia;

                    DB::table('ChiTietHoaDon')->insert([
                        'MaHoaDon' => $hoaDonId,
                        'MaThuoc' => $maThuoc,
                        'SoLuong' => $soLuong,
                        'ThanhTien' => $thanhTien,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // Seed PhieuThu (Receipts)
        $hoaDons = DB::table('HoaDon')->get();
        foreach ($hoaDons as $hoaDon) {
            $tongTien = DB::table('ChiTietHoaDon')
                ->where('MaHoaDon', $hoaDon->MaHoaDon)
                ->sum('ThanhTien');

            DB::table('PhieuThu')->insert([
                'MaHoaDon' => $hoaDon->MaHoaDon,
                'NgayLap' => $hoaDon->NgayLap,
                'NguoiLap' => DB::table('NhanVien')->where('MaNhanVien', $hoaDon->MaNhanVien)->value('HoTen'),
                'SoTien' => $tongTien,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Seed BangLuong (Salary Sheets) and ChiTietLuong (Salary Details)
        foreach ($nhanVienIds as $nhanVienId) {
            $currentDate = clone $startDate;
            while ($currentDate <= $endDate) {
                $luongCoBan = $faker->numberBetween(5000000, 8000000);
                $thuongChuyenCan = $faker->numberBetween(500000, 1000000);
                $thuongKPI = $faker->numberBetween(1000000, 2000000);
                $soNgayNghi = $faker->numberBetween(0, 3);
                $tongLuong = $luongCoBan + $thuongChuyenCan + $thuongKPI - ($soNgayNghi * 200000);

                $bangLuongId = DB::table('BangLuong')->insertGetId([
                    'MaNhanVien' => $nhanVienId,
                    'Thang' => $currentDate->format('Y-m-d'),
                    'LuongCoBan' => $luongCoBan,
                    'ThuongChuyenCan' => $thuongChuyenCan,
                    'ThuongKPI' => $thuongKPI,
                    'SoNgayNghi' => $soNgayNghi,
                    'TongLuong' => $tongLuong,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Salary Details
                $phuCap = [
                    'Phụ cấp ăn trưa' => [500000, 700000],
                    'Phụ cấp xăng xe' => [300000, 500000],
                    'Phụ cấp điện thoại' => [200000, 300000],
                    'Thưởng doanh số' => [1000000, 2000000],
                ];

                foreach ($phuCap as $loai => $range) {
                    DB::table('ChiTietLuong')->insert([
                        'MaBangLuong' => $bangLuongId,
                        'MoTa' => $loai,
                        'SoTien' => $faker->numberBetween($range[0], $range[1]),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $currentDate->addMonth();
            }
        }
    }
}
