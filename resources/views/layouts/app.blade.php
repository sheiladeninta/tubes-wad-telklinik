<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tel-Klinik')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @yield('styles')
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #2c3e50;">
    @if(auth()->check())
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top" style="box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div class="container-fluid">
                <a class="navbar-brand" href="#" style="font-weight: bold; color: #dc3545 !important;">
                    <i class="fas fa-heartbeat me-2"></i>
                    Tel-Klinik
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container-fluid">
            <div class="row">
                @yield('sidebar')
                
                <main class="@yield('main-class', 'col-md-9 ms-sm-auto col-lg-10 px-md-4')" style="padding: 2rem;">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endif
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // CSS Variables untuk JavaScript (jika diperlukan)
        const CSS_VARS = {
            primaryRed: '#dc3545',
            secondaryRed: '#b02a37',
            lightRed: '#f8d7da',
            darkRed: '#721c24',
            textDark: '#2c3e50',
            textLight: '#6c757d'
        };
        
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
        
        // Add active class to current nav item
        document.addEventListener('DOMContentLoaded', function() {
            let currentUrl = window.location.pathname;
            let navLinks = document.querySelectorAll('.sidebar .nav-link');
            
            navLinks.forEach(function(link) {
                if (link.getAttribute('href') === currentUrl) {
                    link.classList.add('active');
                    // Apply active styles inline
                    link.style.backgroundColor = 'rgba(255,255,255,0.2)';
                    link.style.color = 'white';
                }
            });
            
            // Apply hover effects to buttons
            let btnPrimary = document.querySelectorAll('.btn-primary');
            btnPrimary.forEach(function(btn) {
                btn.style.backgroundColor = CSS_VARS.primaryRed;
                btn.style.borderColor = CSS_VARS.primaryRed;
                
                btn.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = CSS_VARS.secondaryRed;
                    this.style.borderColor = CSS_VARS.secondaryRed;
                });
                
                btn.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = CSS_VARS.primaryRed;
                    this.style.borderColor = CSS_VARS.primaryRed;
                });
            });
            
            // Apply hover effects to cards
            let cards = document.querySelectorAll('.card');
            cards.forEach(function(card) {
                card.style.border = 'none';
                card.style.borderRadius = '10px';
                card.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                card.style.transition = 'transform 0.2s';
                
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Apply styles to sidebar
            let sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.style.background = 'linear-gradient(135deg, #dc3545, #b02a37)';
                sidebar.style.minHeight = 'calc(100vh - 56px)';
                sidebar.style.color = 'white';
                
                let sidebarLinks = sidebar.querySelectorAll('.nav-link');
                sidebarLinks.forEach(function(link) {
                    link.style.color = 'rgba(255,255,255,0.8)';
                    link.style.padding = '0.75rem 1rem';
                    link.style.borderRadius = '8px';
                    link.style.margin = '0.25rem 0';
                    link.style.transition = 'all 0.3s';
                    
                    link.addEventListener('mouseenter', function() {
                        if (!this.classList.contains('active')) {
                            this.style.backgroundColor = 'rgba(255,255,255,0.2)';
                            this.style.color = 'white';
                        }
                    });
                    
                    link.addEventListener('mouseleave', function() {
                        if (!this.classList.contains('active')) {
                            this.style.backgroundColor = 'transparent';
                            this.style.color = 'rgba(255,255,255,0.8)';
                        }
                    });
                });
            }
            
            // Apply styles to stat cards
            let statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(function(card) {
                card.style.background = 'linear-gradient(135deg, #fff, #f8f9fa)';
                card.style.borderLeft = '4px solid #dc3545';
            });
            
            // Apply styles to alerts
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                alert.style.border = 'none';
                alert.style.borderRadius = '10px';
            });
            
            // Apply styles to form controls
            let formControls = document.querySelectorAll('.form-control');
            formControls.forEach(function(control) {
                control.addEventListener('focus', function() {
                    this.style.borderColor = CSS_VARS.primaryRed;
                    this.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                });
            });
            
            // Apply styles to auth containers
            let authContainer = document.querySelector('.auth-container');
            if (authContainer) {
                authContainer.style.minHeight = '100vh';
                authContainer.style.background = 'linear-gradient(135deg, #f8d7da, #ffffff)';
            }
            
            let authCard = document.querySelector('.auth-card');
            if (authCard) {
                authCard.style.background = 'white';
                authCard.style.borderRadius = '15px';
                authCard.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
                authCard.style.overflow = 'hidden';
            }
            
            let authHeader = document.querySelector('.auth-header');
            if (authHeader) {
                authHeader.style.background = 'linear-gradient(135deg, #dc3545, #b02a37)';
                authHeader.style.color = 'white';
                authHeader.style.padding = '2rem';
                authHeader.style.textAlign = 'center';
            }
            
            let authBody = document.querySelector('.auth-body');
            if (authBody) {
                authBody.style.padding = '2rem';
            }
            
            // Responsive adjustments
            function applyResponsiveStyles() {
                if (window.innerWidth <= 768) {
                    let sidebar = document.querySelector('.sidebar');
                    if (sidebar) {
                        sidebar.style.minHeight = 'auto';
                    }
                    
                    let mainContent = document.querySelector('main');
                    if (mainContent) {
                        mainContent.style.padding = '1rem';
                    }
                }
            }
            
            // Apply responsive styles on load and resize
            applyResponsiveStyles();
            window.addEventListener('resize', applyResponsiveStyles);
        });
    </script>
    
    @yield('scripts')
</body>
</html>