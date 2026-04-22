<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') — Natural Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @hasSection('styles')
    @else
        @if(request()->routeIs('admin.blogs*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/blogs.css') }}">
        @endif

        @if(request()->routeIs('admin.categories*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
        @endif

        @if(request()->routeIs('admin.fields*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
        @endif

        @if(request()->routeIs('admin.portfolio*') && !request()->routeIs('admin.portfolio-categories*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/portfolio.css') }}">
        @endif

        @if(request()->routeIs('admin.portfolio-categories*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
        @endif

        @if(request()->routeIs('admin.videos*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/blogs.css') }}">
        @endif

        @if(request()->routeIs('admin.video-categories*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/categories.css') }}">
        @endif

        @if(request()->routeIs('admin.services*'))
            <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin/services.css') }}">
        @endif
    @endif

    @yield('styles')
    <link rel="stylesheet" href="{{ \App\Support\VersionedAsset::url('assets/css/admin.css') }}">

</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/images/logo/logo.jpeg') }}" alt="Natural Hub" style="max-width:130px;height:auto;object-fit:contain;">
            </div>
            <div style="text-align:center;padding:0 12px 14px;border-bottom:1px solid rgba(255,255,255,.07);">
                <span style="font-size:.7rem;color:rgba(255,255,255,.35);letter-spacing:1px;text-transform:uppercase;">Admin Panel</span>
            </div>
        </div>

        <nav class="nav flex-column mt-2">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="الرئيسية">
                <i class="fas fa-tachometer-alt"></i>
                <span>الرئيسية</span>
            </a>

            <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}" title="المستخدمين">
                <i class="fas fa-users"></i>
                <span>المستخدمين</span>
            </a>

            <a class="nav-link {{ request()->routeIs('admin.fields*') ? 'active' : '' }}" href="{{ route('admin.fields.index') }}" title="المجالات">
                <i class="fas fa-sitemap"></i>
                <span>المجالات</span>
            </a>

            <!-- المدونة -->
            <div class="nav-dropdown">
                <a class="nav-link dropdown-toggle" 
                   href="#blogSubmenu" 
                   data-bs-toggle="collapse" 
                   role="button" 
                   aria-expanded="{{ request()->routeIs('admin.blogs*') || request()->routeIs('admin.categories*') ? 'true' : 'false' }}"
                   title="المدونة">
                    <i class="fas fa-newspaper"></i>
                    <span>المدونة</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.blogs*') || request()->routeIs('admin.categories*') ? 'show' : '' }}" id="blogSubmenu">
                    <a class="nav-link sub-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i>
                        <span>التصنيفات</span>
                    </a>
                    <a class="nav-link sub-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                        <i class="fas fa-file-alt"></i>
                        <span>المقالات</span>
                    </a>
                </div>
            </div>



            <!-- مكتبة الفيديوهات -->
            <a class="nav-link {{ request()->routeIs('admin.videos*') ? 'active' : '' }}"
               href="{{ route('admin.videos.index') }}" title="مكتبة الفيديوهات">
                <i class="fab fa-youtube"></i>
                <span>مكتبة الفيديوهات</span>
            </a>

            <a class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}" title="الخدمات">
                <i class="fas fa-concierge-bell"></i>
                <span>الخدمات</span>
            </a>

            <!-- الحجوزات -->
            <a class="nav-link {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}" href="{{ route('admin.bookings.index') }}" title="الحجوزات">
                <i class="fas fa-calendar-check"></i>
                <span>الحجوزات</span>
                @php $pendingCount = \App\Models\Booking::pending()->where('appointment_at','>=',now())->count(); @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-warning text-dark ms-auto">{{ $pendingCount }}</span>
                @endif
            </a>

            <!-- الفروع والموظفات -->
            <div class="nav-dropdown">
                <a class="nav-link dropdown-toggle"
                   href="#opsSubmenu"
                   data-bs-toggle="collapse"
                   role="button"
                   aria-expanded="{{ request()->routeIs('admin.branches*') || request()->routeIs('admin.staff*') ? 'true' : 'false' }}"
                   title="العمليات">
                    <i class="fas fa-store"></i>
                    <span>الفروع والموظفات</span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.branches*') || request()->routeIs('admin.staff*') ? 'show' : '' }}" id="opsSubmenu">
                    <a class="nav-link sub-link {{ request()->routeIs('admin.branches*') ? 'active' : '' }}" href="{{ route('admin.branches.index') }}">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>الفروع</span>
                    </a>
                    <a class="nav-link sub-link {{ request()->routeIs('admin.staff*') ? 'active' : '' }}" href="{{ route('admin.staff.index') }}">
                        <i class="fas fa-user-tie"></i>
                        <span>الموظفات</span>
                    </a>
                </div>
            </div>

            <!-- العميلات (CRM) -->
            <a class="nav-link {{ request()->routeIs('admin.customers*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}" title="العميلات">
                <i class="fas fa-heart"></i>
                <span>العميلات</span>
            </a>

            <!-- معرض الصور -->
            <a class="nav-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}" href="{{ route('admin.gallery.index') }}" title="معرض الصور">
                <i class="fas fa-images"></i>
                <span>معرض الصور</span>
            </a>

            <!-- المتجر -->
            <a class="nav-link {{ request()->routeIs('admin.shop*') ? 'active' : '' }}" href="{{ route('admin.shop.index') }}" title="المتجر">
                <i class="fas fa-shopping-bag"></i>
                <span>المتجر</span>
            </a>

            <!-- التقارير -->
            <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}" title="التقارير">
                <i class="fas fa-chart-bar"></i>
                <span>التقارير</span>
            </a>

            <div class="sidebar-separator"></div>

            <a class="nav-link" href="{{ route('home') }}" target="_blank" title="عرض الموقع">
                <i class="fas fa-external-link-alt"></i>
                <span>عرض الموقع</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start" title="تسجيل الخروج">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>تسجيل الخروج</span>
                </button>
            </form>
        </nav>
    </div>

    <div class="main-content" id="mainContent">
        <nav class="admin-navbar">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <button class="navbar-toggler d-md-none me-3" type="button" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h5 class="navbar-brand mb-0">@yield('page-title', 'لوحة التحكم')</h5>
                </div>

                <div class="user-menu">
                    <span class="text-muted d-none d-sm-inline">مرحبًا،</span>
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle d-flex align-items-center text-decoration-none" type="button" id="userDropdown" data-bs-toggle="dropdown">
                            <div class="user-avatar me-2">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i>
                                    الملف الشخصي
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    عرض الموقع
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>
                                        تسجيل الخروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="p-4">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });

            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768 && sidebarToggle) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });


        });
    </script>

    @if(request()->routeIs('admin.blogs.create') || request()->routeIs('admin.blogs.edit') || request()->routeIs('admin.portfolio.create') || request()->routeIs('admin.portfolio.edit'))
        <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css">
        <style>
            .ck-editor__main { min-height: 400px; }
            .ck-editor__editable_inline { min-height: 500px; }
            .ck-content {
                direction: rtl;
                text-align: right;
                font-family: 'Cairo', sans-serif;
                font-size: 16px;
                line-height: 1.6;
            }
            .ck-editor__editable { border-radius: 10px; }
        </style>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.app-sort-order-input').forEach(input => {
                input.addEventListener('change', function() {
                    const id = this.getAttribute('data-id');
                    const model = this.getAttribute('data-model');
                    const sort_order = this.value;
                    const originalValue = this.defaultValue;
                    
                    fetch('{{ route("admin.update-sort-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ id, model, sort_order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.defaultValue = sort_order;
                            this.style.borderColor = '#28a745';
                            this.style.backgroundColor = '#e8f5e9';
                            setTimeout(() => {
                                this.style.borderColor = '';
                                this.style.backgroundColor = '';
                            }, 1000);
                        } else {
                            alert('حدث خطأ');
                            this.value = originalValue;
                        }
                    })
                    .catch(e => {
                        alert('حدث خطأ في الشبكة');
                        this.value = originalValue;
                    });
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
