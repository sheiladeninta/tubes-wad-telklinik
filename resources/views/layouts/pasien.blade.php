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
                        <a class="nav-link {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}" href="{{ route('pasien.dashboard') }}" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none; {{ request()->routeIs('pasien.dashboard') ? 'background-color: #f8d7da; color: #dc3545; border-left-color: #dc3545; font-weight: 600;' : '' }}">
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
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-calendar-plus" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Buat Reservasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-calendar-check" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Riwayat Reservasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
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
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-file-medical" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-pills" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Resep Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-file-alt" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Surat Keterangan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-chart-line" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Riwayat Kesehatan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Layanan Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Layanan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-comments" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Konsultasi Online
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-download" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Unduh Dokumen
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Akun Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Akun</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-user-edit" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Edit Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent';">
                            <i class="fas fa-bell" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Notifikasi
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mainContent = document.getElementById('mainContent');
            let sidebarVisible = true;
            
            // Sidebar toggle functionality
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    if (window.innerWidth > 768) {
                        // Desktop behavior
                        sidebarVisible = !sidebarVisible;
                        if (sidebarVisible) {
                            sidebar.style.transform = 'translateX(0)';
                            mainContent.style.marginLeft = '280px';
                        } else {
                            sidebar.style.transform = 'translateX(-100%)';
                            mainContent.style.marginLeft = '0';
                        }
                    } else {
                        // Mobile behavior
                        sidebar.classList.toggle('show');
                        sidebarOverlay.classList.toggle('show');
                    }
                });
            }
            
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    // Mobile mode
                    sidebar.style.transform = '';
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    sidebarOverlay.style.display = 'none';
                    mainContent.style.marginLeft = '0';
                } else {
                    // Desktop mode
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    sidebarOverlay.style.display = 'none';
                    if (sidebarVisible) {
                        sidebar.style.transform = 'translateX(0)';
                        mainContent.style.marginLeft = '280px';
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                        mainContent.style.marginLeft = '0';
                    }
                }
            });
            
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
        
        // Add mobile styles for sidebar
        const mobileStyles = `
            @media (max-width: 768px) {
                .sidebar {
                    transform: translateX(-100%) !important;
                }
                
                .sidebar.show {
                    transform: translateX(0) !important;
                }
                
                .main-content {
                    margin-left: 0 !important;
                }
                
                .content-wrapper {
                    padding: 1rem !important;
                }
                
                .mobile-sidebar-overlay.show {
                    display: block !important;
                }
            }
        `;
        
        const styleSheet = document.createElement('style');
        styleSheet.textContent = mobileStyles;
        document.head.appendChild(styleSheet);
    </script>
    
    @yield('scripts')
</body>
</html>