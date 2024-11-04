<!-- resources/views/sidebar.blade.php -->

<aside class="app-sidebar bg-light shadow">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand text-center py-4">
        <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
            <span class="brand-text fw-light fs-4">Quản lý Nhà thuốc</span>
        </a>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav flex-column sidebar-menu">
                <!-- Dashboard -->
                <li class="nav-item mb-2">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 nav-icon me-2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- Common Menu -->
                <li class="nav-item mb-2">
                    <a href="{{ route('khachhang.index') }}" class="nav-link {{ request()->routeIs('khachhang.*') ? 'active' : '' }}">
                        <i class="bi bi-people nav-icon me-2"></i>
                        <span>Khách hàng</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="{{ route('thuoc.index') }}" class="nav-link {{ request()->routeIs('thuoc.*') ? 'active' : '' }}">
                        <i class="bi bi-capsule nav-icon me-2"></i>
                        <span>Thuốc</span>
                    </a>
                </li>

                <li class="nav-item mb-4">
                    <a href="{{ route('hoadon.index') }}" class="nav-link {{ request()->routeIs('hoadon.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt nav-icon me-2"></i>
                        <span>Hóa đơn</span>
                    </a>
                </li>

                {{-- Manager Menu --}}
                @role('quản lý')
                    <li class="nav-header text-uppercase text-secondary fw-bold mb-3">Quản lý</li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('nhanvien.index') }}" class="nav-link {{ request()->routeIs('nhanvien.*') ? 'active' : '' }}">
                            <i class="bi bi-person-badge nav-icon me-2"></i>
                            <span>Nhân viên</span>
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('nhacungcap.index') }}" class="nav-link {{ request()->routeIs('nhacungcap.*') ? 'active' : '' }}">
                            <i class="bi bi-building nav-icon me-2"></i>
                            <span>Nhà cung cấp</span>
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a href="{{ route('bangluong.index') }}" class="nav-link {{ request()->routeIs('bangluong.*') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack nav-icon me-2"></i>
                            <span>Bảng lương</span>
                        </a>
                    </li>
                @endrole
            </ul>
        </nav>
    </div>
</aside>
