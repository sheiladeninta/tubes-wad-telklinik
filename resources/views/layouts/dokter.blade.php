<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Dokter - Tel-Klinik')</title>
    
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
            
            <a class="navbar-brand" href="{{ route('dokter.dashboard') }}" style="font-weight: bold; color: white !important; font-size: 1.5rem; text-decoration: none;">
                <i class="fas fa-user-md me-2"></i>
                Tel-Klinik Dokter
            </a>
            
            <!-- Top Right Menu -->
            <div class="navbar-nav ms-auto d-flex flex-row align-items-center">
                <!-- Notifications -->
                <div class="nav-item dropdown me-3">
                    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" style="color: rgba(255,255,255,0.9) !important; font-weight: 500; text-decoration: none;">
                        <i class="fas fa-bell"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.1); border-radius: 10px; width: 320px;">
                        <li><h6 class="dropdown-header">Notifikasi Terbaru</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calendar me-2 text-success"></i>Jadwal konsultasi dalam 30 menit</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-injured me-2 text-warning"></i>Pasien baru menunggu pemeriksaan</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-pills me-2 text-info"></i>Stok obat perlu diperbarui</a></li>
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
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil Dokter</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
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

            <!-- Pasien Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Manajemen Pasien</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-users" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Daftar Pasien
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-calendar-check" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Jadwal Praktik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-clock" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Antrian Hari Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-comments" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Konsultasi Online
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Rekam Medis Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Rekam Medis</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-file-medical-alt" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Buat Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-search" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Cari Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-history" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Riwayat Pemeriksaan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Resep & Obat Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Farmasi</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-prescription" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Buat Resep
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-pills" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Stok Obat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-chart-bar" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Laporan Resep
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Dokumen Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Dokumen</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-file-alt" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Surat Keterangan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-file-signature" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Tanda Tangan Digital
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-archive" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Arsip Dokumen
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Laporan Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Laporan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-chart-line" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Statistik Praktik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-file-pdf" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Laporan Bulanan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-chart-pie" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Analisis Penyakit
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Pengaturan Section -->
            <div class="nav-section" style="padding: 0 1.5rem; margin-bottom: 1.5rem;">
                <div class="nav-section-title" style="font-size: 0.8rem; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">Pengaturan</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-user-edit" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Profil Dokter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-cog" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Pengaturan Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2c3e50; padding: 0.75rem 1.5rem; margin: 0.2rem 0; border-radius: 0; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; text-decoration: none;" onmouseover="this.style.backgroundColor='#f8d7da'; this.style.color='#dc3545'; this.style.borderLeftColor='#dc3545'; this.querySelector('i').style.color='#dc3545';" onmouseout="this.style.backgroundColor=''; this.style.color='#2c3e50'; this.style.borderLeftColor='transparent'; this.querySelector('i').style.color='#6c757d';">
                            <i class="fas fa-bell" style="width: 20px; margin-right: 10px; color: #6c757d;"></i>
                            Notifikasi
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1010; display: none;"></div>

    <!-- Main Content -->
    <main class="main-content" id="mainContent" style="margin-left: 280px; padding-top: 76px; min-height: 100vh; transition: margin-left 0.3s ease;">
        <div class="container-fluid" style="padding: 2rem;">
            @yield('content')
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            let sidebarOpen = true;

            function toggleSidebar() {
                sidebarOpen = !sidebarOpen;
                
                if (window.innerWidth >= 992) {
                    // Desktop behavior
                    if (sidebarOpen) {
                        sidebar.style.transform = 'translateX(0)';
                        mainContent.style.marginLeft = '280px';
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                        mainContent.style.marginLeft = '0';
                    }
                } else {
                    // Mobile behavior
                    if (sidebarOpen) {
                        sidebar.style.transform = 'translateX(0)';
                        sidebarOverlay.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                        sidebarOverlay.style.display = 'none';
                        document.body.style.overflow = 'auto';
                    }
                }
            }

            function handleResize() {
                if (window.innerWidth < 992) {
                    // Mobile: hide sidebar by default
                    sidebar.style.transform = 'translateX(-100%)';
                    mainContent.style.marginLeft = '0';
                    sidebarOverlay.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    sidebarOpen = false;
                } else {
                    // Desktop: show sidebar by default
                    sidebar.style.transform = 'translateX(0)';
                    mainContent.style.marginLeft = '280px';
                    sidebarOverlay.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    sidebarOpen = true;
                }
            }

            // Initialize
            handleResize();

            // Event listeners
            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    toggleSidebar();
                }
            });

            window.addEventListener('resize', handleResize);

            // Close sidebar on mobile when clicking nav links
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992 && sidebarOpen) {
                        toggleSidebar();
                    }
                });
            });
        });

        // Active Navigation Highlight
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    // Remove active class from all links
                    navLinks.forEach(l => l.classList.remove('active'));
                    // Add active class to current link
                    link.classList.add('active');
                    link.style.cssText = `
                        color: #dc3545 !important; 
                        background-color: #f8d7da !important; 
                        border-left: 3px solid #dc3545 !important; 
                        font-weight: 600 !important;
                        padding: 0.75rem 1.5rem !important; 
                        margin: 0.2rem 0 !important; 
                        border-radius: 0 !important; 
                        transition: all 0.3s ease !important; 
                        display: flex !important; 
                        align-items: center !important; 
                        text-decoration: none !important;
                    `;
                    const icon = link.querySelector('i');
                    if (icon) {
                        icon.style.color = '#dc3545';
                    }
                }
            });
        });

        // Smooth scrolling for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Auto-dismiss alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('alert-dismissible')) {
                    setTimeout(() => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 5000);
                }
            });
        });

        // Tooltip initialization
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // Popover initialization  
        document.addEventListener('DOMContentLoaded', function() {
            const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });
        });

        // Form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });

        // Loading state for buttons
        function showButtonLoading(button, loadingText = 'Memproses...') {
            const originalText = button.innerHTML;
            button.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText}`;
            button.disabled = true;
            button.setAttribute('data-original-text', originalText);
        }

        function hideButtonLoading(button) {
            const originalText = button.getAttribute('data-original-text');
            if (originalText) {
                button.innerHTML = originalText;
                button.disabled = false;
                button.removeAttribute('data-original-text');
            }
        }
    </script>

    @yield('scripts')
</body>
</html>