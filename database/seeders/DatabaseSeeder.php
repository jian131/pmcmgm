<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class, // Chạy seeder vai trò trước
        ]);

        $faker = Faker::create('vi_VN');

        // Tạo một tài khoản admin mẫu
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Gán vai trò quản lý cho admin
        $admin = DB::table('users')->where('email', 'admin@example.com')->first();
        $quanLyRole = DB::table('roles')->where('name', 'quản lý')->first();
        DB::table('model_has_roles')->insert([
            'role_id' => $quanLyRole->id,
            'model_type' => 'App\Models\User',
            'model_id' => $admin->id,
        ]);

        // Seed KhachHang
        $khachHangIds = [];
        for ($i = 1; $i <= 50; $i++) {
            $khachHangIds[] = DB::table('KhachHang')->insertGetId([
                'TenKhachHang' => $faker->name,
                'SoDienThoai' => $faker->unique()->numerify('0#########'),
                'DiaChi' => $faker->address,
                'DiemTichLuy' => $faker->numberBetween(0, 5000)
            ]);
        }

        // Seed NhanVien
        $nhanVienIds = [];
        for ($i = 1; $i <= 20; $i++) {
            $nhanVienIds[] = DB::table('NhanVien')->insertGetId([
                'HoTen' => $faker->name,
                'NgaySinh' => $faker->dateTimeBetween('-40 years', '-20 years'),
                'DiaChi' => $faker->address,
                'SoDienThoai' => $faker->unique()->numerify('0#########')
            ]);
        }

        // Seed Thuoc
        $nhomThuoc = [
            'Kháng sinh' => ['Amoxicillin', 'Cephalexin', 'Azithromycin'],
            'Giảm đau, hạ sốt' => ['Paracetamol', 'Ibuprofen', 'Aspirin'],
            'Tim mạch' => ['Amlodipine', 'Losartan', 'Atenolol'],
        ];

        $hangSanXuat = [
            'Công ty Dược Hậu Giang (DHG)',
            'Công ty Dược Traphaco',
            'Công ty Dược phẩm Imexpharm',
        ];

        $thuocIds = [];
        foreach ($nhomThuoc as $nhom => $danhSachThuoc) {
            foreach ($danhSachThuoc as $tenThuoc) {
                $thuocIds[] = DB::table('Thuoc')->insertGetId([
                    'TenThuoc' => $tenThuoc,
                    'NhomLoaiThuoc' => $nhom,
                    'HangSanXuat' => $faker->randomElement($hangSanXuat),
                    'HanSuDung' => $faker->dateTimeBetween('+1 year', '+3 years'),
                    'SoLuong' => $faker->numberBetween(100, 1000),
                    'Gia' => $faker->numberBetween(5000, 500000)
                ]);
            }
        }

        // Seed NhaCungCap
        $nhaCungCapIds = [];
        for ($i = 1; $i <= 15; $i++) {
            $nhaCungCapIds[] = DB::table('NhaCungCap')->insertGetId([
                'TenNhaCungCap' => $faker->company,
                'DiaChi' => $faker->address,
                'SoDienThoai' => $faker->unique()->numerify('0#########')
            ]);
        }

        // Seed HoaDon và ChiTietHoaDon
        $hoaDonIds = [];
        for ($i = 1; $i <= 100; $i++) {
            $hoaDonIds[] = $hoaDonId = DB::table('HoaDon')->insertGetId([
                'NgayLap' => $faker->dateTimeBetween('-1 year', 'now'),
                'MaKhachHang' => $faker->randomElement($khachHangIds),
                'MaNhanVien' => $faker->randomElement($nhanVienIds)
            ]);

            // Tạo 2-5 chi tiết hóa đơn cho mỗi hóa đơn
            $usedThuocIds = [];
            for ($j = 0; $j < $faker->numberBetween(2, 5); $j++) {
                $maThuoc = $faker->randomElement($thuocIds);
                // Kiểm tra trùng lặp
                if (!in_array($maThuoc, $usedThuocIds)) {
                    $usedThuocIds[] = $maThuoc;
                    $soLuong = $faker->numberBetween(1, 10);
                    $gia = $faker->numberBetween(5000, 500000);
                    DB::table('ChiTietHoaDon')->insert([
                        'MaHoaDon' => $hoaDonId,
                        'MaThuoc' => $maThuoc,
                        'SoLuong' => $soLuong,
                        'ThanhTien' => $soLuong * $gia
                    ]);
                }
            }
        }



        // Seed PhieuThu
        foreach ($hoaDonIds as $hoaDonId) {
            DB::table('PhieuThu')->insert([
                'MaHoaDon' => $hoaDonId,
                'NgayLap' => $faker->dateTimeBetween('-1 year', 'now'),
                'NguoiLap' => $faker->randomElement($nhanVienIds),
                'SoTien' => $faker->numberBetween(50000, 5000000)
            ]);
        }

        // Seed PhieuNhap
        for ($i = 1; $i <= 200; $i++) {
            $maThuoc = $faker->randomElement($thuocIds);
            $thuoc = DB::table('Thuoc')->where('MaThuoc', $maThuoc)->first();

            DB::table('PhieuNhap')->insert([
                'NgayNhap' => $faker->dateTimeBetween('-1 year', 'now'),
                'MaThuoc' => $maThuoc,
                'TenThuoc' => $thuoc->TenThuoc,
                'SoLuong' => $faker->numberBetween(100, 1000),
                'MaNhaCungCap' => $faker->randomElement($nhaCungCapIds)
            ]);
        }

        // Seed BangLuong
        $bangLuongIds = [];
        foreach ($nhanVienIds as $nhanVienId) {
            // 6 tháng lương cho mỗi nhân viên
            for ($i = 1; $i <= 6; $i++) {
                $luongCoBan = $faker->numberBetween(5000000, 10000000);
                $thuongChuyenCan = $faker->numberBetween(500000, 2000000);
                $thuongKPI = $faker->numberBetween(1000000, 5000000);
                $soNgayNghi = $faker->numberBetween(0, 5);
                $tongLuong = $luongCoBan + $thuongChuyenCan + $thuongKPI - ($soNgayNghi * 200000); // Trừ 200k mỗi ngày nghỉ

                $bangLuongIds[] = DB::table('BangLuong')->insertGetId([
                    'MaNhanVien' => $nhanVienId,
                    'Thang' => $faker->dateTimeBetween('-6 months', 'now'),
                    'LuongCoBan' => $luongCoBan,
                    'ThuongChuyenCan' => $thuongChuyenCan,
                    'ThuongKPI' => $thuongKPI,
                    'SoNgayNghi' => $soNgayNghi,
                    'TongLuong' => $tongLuong
                ]);
            }
        }

        // Seed ChiTietLuong
        $loaiPhuCap = [
            'Phụ cấp ăn trưa' => [150000, 300000],
            'Phụ cấp xăng xe' => [200000, 500000],
            'Phụ cấp điện thoại' => [100000, 200000],
            'Thưởng doanh số' => [500000, 2000000],
            'Phụ cấp độc hại' => [300000, 800000],
            'Phụ cấp trách nhiệm' => [400000, 1000000]
        ];

        foreach ($bangLuongIds as $bangLuongId) {
            // 2-4 loại phụ cấp cho mỗi bảng lương
            $selectedPhuCap = $faker->randomElements(array_keys($loaiPhuCap), $faker->numberBetween(2, 4));

            foreach ($selectedPhuCap as $loai) {
                [$min, $max] = $loaiPhuCap[$loai];
                DB::table('ChiTietLuong')->insert([
                    'MaBangLuong' => $bangLuongId,
                    'MoTa' => $loai,
                    'SoTien' => $faker->numberBetween($min, $max)
                ]);
            }
        }// Continue from previous code...

        // Seed PhieuThu
        foreach ($hoaDonIds as $hoaDonId) {
            DB::table('PhieuThu')->insert([
                'MaHoaDon' => $hoaDonId,
                'NgayLap' => $faker->dateTimeBetween('-1 year', 'now'),
                'NguoiLap' => $faker->randomElement($nhanVienIds),
                'SoTien' => $faker->numberBetween(50000, 5000000)
            ]);
        }

        // Seed PhieuNhap
        for ($i = 1; $i <= 200; $i++) {
            $maThuoc = $faker->randomElement($thuocIds);
            $thuoc = DB::table('Thuoc')->where('MaThuoc', $maThuoc)->first();

            DB::table('PhieuNhap')->insert([
                'NgayNhap' => $faker->dateTimeBetween('-1 year', 'now'),
                'MaThuoc' => $maThuoc,
                'TenThuoc' => $thuoc->TenThuoc,
                'SoLuong' => $faker->numberBetween(100, 1000),
                'MaNhaCungCap' => $faker->randomElement($nhaCungCapIds)
            ]);
        }

        // Seed BangLuong
        $bangLuongIds = [];
        foreach ($nhanVienIds as $nhanVienId) {
            // 6 tháng lương cho mỗi nhân viên
            for ($i = 1; $i <= 6; $i++) {
                $luongCoBan = $faker->numberBetween(5000000, 10000000);
                $thuongChuyenCan = $faker->numberBetween(500000, 2000000);
                $thuongKPI = $faker->numberBetween(1000000, 5000000);
                $soNgayNghi = $faker->numberBetween(0, 5);
                $tongLuong = $luongCoBan + $thuongChuyenCan + $thuongKPI - ($soNgayNghi * 200000); // Trừ 200k mỗi ngày nghỉ

                $bangLuongIds[] = DB::table('BangLuong')->insertGetId([
                    'MaNhanVien' => $nhanVienId,
                    'Thang' => $faker->dateTimeBetween('-6 months', 'now'),
                    'LuongCoBan' => $luongCoBan,
                    'ThuongChuyenCan' => $thuongChuyenCan,
                    'ThuongKPI' => $thuongKPI,
                    'SoNgayNghi' => $soNgayNghi,
                    'TongLuong' => $tongLuong
                ]);
            }
        }

        // Seed ChiTietLuong
        $loaiPhuCap = [
            'Phụ cấp ăn trưa' => [150000, 300000],
            'Phụ cấp xăng xe' => [200000, 500000],
            'Phụ cấp điện thoại' => [100000, 200000],
            'Thưởng doanh số' => [500000, 2000000],
            'Phụ cấp độc hại' => [300000, 800000],
            'Phụ cấp trách nhiệm' => [400000, 1000000]
        ];

        foreach ($bangLuongIds as $bangLuongId) {
            // 2-4 loại phụ cấp cho mỗi bảng lương
            $selectedPhuCap = $faker->randomElements(array_keys($loaiPhuCap), $faker->numberBetween(2, 4));

            foreach ($selectedPhuCap as $loai) {
                [$min, $max] = $loaiPhuCap[$loai];
                DB::table('ChiTietLuong')->insert([
                    'MaBangLuong' => $bangLuongId,
                    'MoTa' => $loai,
                    'SoTien' => $faker->numberBetween($min, $max)
                ]);
            }
        }
    }
}
