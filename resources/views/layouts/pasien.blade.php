<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Pasien - Tel-Klinik')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @yield('styles')
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #2c3e50;">
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background: linear-gradient(135deg, #dc3545, #b02a37); box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1030;">
        <div class="container-fluid">
            <!-- Desktop Menu Toggle -->
            <button class="btn btn-link text-white me-2" type="button" id="sidebarToggle" style="border: none; background: none;">
                <i class="fas fa-bars"></i>
            </button>
            
            <a class="navbar-brand" href="{{ route('pasien.dashboard') }}" style="font-weight: bold; color: white !important; font-size: 1.5rem; text-decoration: none;">
                <i class="fas fa-heartbeat me-2"></i>
                Tel-Klinik
            </a>
            
            <!-- Top Right Menu -->
            <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <!-- Notifications -->
                <div class="nav-item dropdown me-3">
                    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" style="color: rgba(255,255,255,0.9) !important; font-weight: 500; text-decoration: none;">
                        <i class="fas fa-bell"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 10px;">
                        <li><h6 class="dropdown-header">Notifikasi Terbaru</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2 text-success"></i>Reservasi dikonfirmasi</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-pills me-2 text-info"></i>Resep obat siap diambil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-alt me-2 text-warning"></i>Surat keterangan tersedia</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#">Lihat Semua Notifikasi</a></li>
                    </ul>
                </div>
                
                <!-- User Menu -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" style="color: rgba(255,255,255,0.9) !important; font-weight: 500; text-decoration: none;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=dc3545&color=fff" 
                             class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                        <span class="d-none d-lg-inline">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 10px;">
                        <li><h6 class="dropdown-header">{{ auth()->user()->name }}</h6></li>
                        <li><small class="dropdown-item-text text-muted">{{ auth()->user()->email }}</small></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left;">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" style="position: fixed; top: 0; left: 0; height: 100vh; width: 280px; background: white; box-shadow: 2px 0 10px rgba(0,0,0,0.1); z-index: 1020; padding-top: 76px; overflow-y: auto; transition: transform 0.3s ease;">
        <div class="sidebar-nav" style="padding: 1rem 0;">
            <!-- Dashboard Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Dashboard</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}" href="{{ route('pasien.dashboard') }}" style="color: {{ request()->routeIs('pasien.dashboard') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.dashboard') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.dashboard') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.dashboard') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-tachometer-alt" style="width: 20px; margin-right: 10px; color: {{ request()->routeIs('pasien.dashboard') ? '#dc3545' : '#6c757d' }};"></i>
                            Dashboard Utama
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Reservasi Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Reservasi</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.reservasi.create') ? 'active' : '' }}" href="{{ route('pasien.reservasi.create') }}" style="color: {{ request()->routeIs('pasien.reservasi.create') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.reservasi.create') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.reservasi.create') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.reservasi.create') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-calendar-plus" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Buat Reservasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.reservasi.index') ? 'active' : '' }}" href="{{ route('pasien.reservasi.index') }}" style="color: {{ request()->routeIs('pasien.reservasi.index') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.reservasi.index') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.reservasi.index') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.reservasi.index') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-calendar-check" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Riwayat Reservasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.reservasi.upcoming') ? 'active' : '' }}" href="{{ route('pasien.reservasi.upcoming') }}" style="color: {{ request()->routeIs('pasien.reservasi.upcoming') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.reservasi.upcoming') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.reservasi.upcoming') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.reservasi.upcoming') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-clock" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Jadwal Mendatang
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Kesehatan Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Kesehatan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.rekam-medis.index') ? 'active' : '' }}" href="{{ route('pasien.rekam-medis.index') }}" style="color: {{ request()->routeIs('pasien.rekam-medis.index') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.rekam-medis.index') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.rekam-medis.index') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.rekam-medis.index') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-file-medical" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.resep-obat.*') ? 'active' : '' }}" href="{{ route('pasien.resep-obat.index') }}" style="color: {{ request()->routeIs('pasien.resep-obat.*') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.resep-obat.*') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.resep-obat.*') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.resep-obat.*') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-pills" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Resep Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.surat-keterangan.index') ? 'active' : '' }}" href="{{ route('pasien.surat-keterangan.index') }}" style="color: {{ request()->routeIs('pasien.surat-keterangan.index') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.surat-keterangan.index') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.surat-keterangan.index') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.surat-keterangan.index') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-file-alt" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Surat Keterangan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Layanan Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Layanan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pasien.consultation.index') ? 'active' : '' }}" href="{{ route('pasien.consultation.index') }}" style="color: {{ request()->routeIs('pasien.consultation.index') ? '#dc3545' : '#2c3e50' }}; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid {{ request()->routeIs('pasien.consultation.index') ? '#dc3545' : 'transparent' }}; display: flex; align-items: center; text-decoration: none; background-color: {{ request()->routeIs('pasien.consultation.index') ? '#f8d7da' : 'transparent' }}; font-weight: {{ request()->routeIs('pasien.consultation.index') ? '600' : 'normal' }};" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="if (!this.classList.contains('active')) { this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; }">
                            <i class="fas fa-comments" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Konsultasi Online
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar Overlay -->
    <div class="mobile-sidebar-overlay" id="sidebarOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1010; display: none;"></div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent" style="margin-left: 280px; padding-top: 76px; min-height: 100vh; transition: margin-left 0.3s ease;">
        <div class="content-wrapper" style="padding: 2rem;">
            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        // State untuk menyimpan status sidebar
        let sidebarCollapsed = false;
        
        // Fungsi untuk toggle sidebar
        function toggleSidebar() {
            sidebarCollapsed = !sidebarCollapsed;
            
            if (sidebarCollapsed) {
                // Hide sidebar
                sidebar.style.transform = 'translateX(-100%)';
                mainContent.style.marginLeft = '0';
                
                // Simpan state ke sessionStorage
                sessionStorage.setItem('sidebarCollapsed', 'true');
            } else {
                // Show sidebar
                sidebar.style.transform = 'translateX(0)';
                mainContent.style.marginLeft = '280px';
                
                // Simpan state ke sessionStorage
                sessionStorage.setItem('sidebarCollapsed', 'false');
            }
        }
        
        // Event listener untuk toggle button
        sidebarToggle.addEventListener('click', toggleSidebar);
        
        // Event listener untuk overlay (mobile)
        sidebarOverlay.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                toggleSidebar();
                sidebarOverlay.style.display = 'none';
            }
        });
        
        // Fungsi untuk mengatur responsive behavior
        function handleResize() {
            if (window.innerWidth <= 768) {
                // Mobile view
                sidebar.style.transform = 'translateX(-100%)';
                mainContent.style.marginLeft = '0';
                sidebarOverlay.style.display = 'none';
            } else {
                // Desktop view - restore saved state
                const savedState = sessionStorage.getItem('sidebarCollapsed');
                
                if (savedState === 'true') {
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.style.marginLeft = '0';
                    sidebarCollapsed = true;
                } else {
                    sidebar.style.transform = 'translateX(0)';
                    mainContent.style.marginLeft = '280px';
                    sidebarCollapsed = false;
                }
                
                sidebarOverlay.style.display = 'none';
            }
        }
        
        // Handle window resize
        window.addEventListener('resize', handleResize);
        
        // Load saved state on page load
        const savedState = sessionStorage.getItem('sidebarCollapsed');
        if (savedState === 'true' && window.innerWidth > 768) {
            sidebarCollapsed = true;
            sidebar.style.transform = 'translateX(-100%)';
            mainContent.style.marginLeft = '0';
        }
        
        // Enhanced mobile toggle
        if (window.innerWidth <= 768) {
            sidebarToggle.addEventListener('click', function() {
                if (sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === '') {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebarOverlay.style.display = 'none';
                } else {
                    sidebar.style.transform = 'translateX(0)';
                    sidebarOverlay.style.display = 'block';
                }
            });
        }
        
        // Initialize responsive behavior
        handleResize();
    });
    </script>
    @yield('scripts')
</body>
@stack('scripts')
</html>