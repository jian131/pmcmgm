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

        // Các phần seed khác tương tự...
    }
}
