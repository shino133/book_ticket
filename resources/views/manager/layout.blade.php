<!DOCTYPE html>
<html lang="vi">

@php
    use Illuminate\Support\Facades\Route;
    use Carbon\Carbon;
    $shows = \App\Models\Show::with('movie')->where('date', '>', Carbon::now())->orderBy('date')->get();
@endphp

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- ===== Favicon ===== -->
    <link rel="shortcut icon" href={{ asset('images/branding/logos/favicon.png') }} type="image/x-icon">

    <title>{{ config('app.name') }} | Bảng điều khiển quản trị</title>

    <!-- Phông chữ tùy chỉnh cho mẫu này -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nunito-font.css') }}">

    <!-- Kiểu tùy chỉnh cho mẫu này -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    @stack('head')

</head>

<body id="page-top">

    <!-- Vỏ trang -->
    <div id="wrapper">

        <!-- Thanh bên -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Logo thương hiệu -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <img class="w-100" src="{{ asset('images/branding/logos/logo-w.png') }}" alt="Logo Cinemat">
            </a>

            <!-- Phân cách -->
            <hr class="sidebar-divider my-0">

            <!-- Mục điều hướng - Bảng điều khiển -->
            <li class="nav-item {{ Route::is('manager.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('manager.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Bảng điều khiển</span></a>
            </li>

            <!-- Phân cách -->
            <hr class="sidebar-divider">

            <!-- Tiêu đề -->
            <div class="sidebar-heading">Phim</div>

            <!-- Mục điều hướng - Phim -->
            <li class="nav-item {{ Route::is('manager.movies.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMovie"
                    aria-expanded="true" aria-controls="collapseMovie">
                    <i class="fas fa-fw fa-film"></i>
                    <span>Phim</span>
                </a>
                <div id="collapseMovie" class="collapse {{ Route::is('manager.movies.*') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Route::is(['manager.movies.index', 'manager.movies.show', 'manager.movies.edit']) ? 'active' : '' }}"
                            href="{{ route('manager.movies.index') }}">Xem danh sách phim</a>
                        <a class="collapse-item {{ Route::is('manager.movies.create') ? 'active' : '' }}"
                            href="{{ route('manager.movies.create') }}">Thêm phim mới</a>
                    </div>
                </div>
            </li>

            <!-- Phân cách -->
            <hr class="sidebar-divider">

            <!-- Tiêu đề -->
            <div class="sidebar-heading">Suất chiếu</div>

            <!-- Mục điều hướng - Suất chiếu -->
            <li class="nav-item {{ Route::is('manager.shows.*') ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShow"
                    aria-expanded="true" aria-controls="collapseShow">
                    <i class="fas fa-fw fa-compact-disc"></i>
                    <span>Suất chiếu</span>
                </a>
                <div id="collapseShow" class="collapse {{ Route::is('manager.shows.*') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ Route::is(['manager.shows.index', 'manager.shows.edit', 'manager.shows.show']) ? 'active' : '' }}"
                            href="{{ route('manager.shows.index') }}">Xem danh sách suất chiếu</a>
                        <a class="collapse-item {{ Route::is('manager.shows.create') ? 'active' : '' }}"
                            href="{{ route('manager.shows.create') }}">Thêm suất chiếu mới</a>
                    </div>
                </div>
            </li>

            <!-- Phân cách -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Nút thu gọn thanh bên -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- Kết thúc thanh bên -->

        <!-- Nội dung trang -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Nội dung chính -->
            <div id="content">

                <!-- Thanh điều hướng -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Nút thu gọn thanh bên -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Thanh tìm kiếm -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Tìm kiếm..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Điều hướng trên thanh trên cùng -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Mục thông báo -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter">{{ $shows->count() }}</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Thông báo suất chiếu sắp tới
                                </h6>
                                @foreach ($shows->take(5) as $show)
                                    <a class="dropdown-item d-flex align-items-center"
                                        href="{{ route('manager.shows.show', $show->id) }}">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-compact-disc text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="small text-gray-500">
                                                {{ $show->date->diffForHumans() }}
                                            </div>
                                            <span class="font-weight-bold">Suất chiếu sắp tới cho {{ $show->movie->title }}.</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- Kết thúc thanh điều hướng -->

                <!-- Nội dung trang -->
                <div class="container-fluid">
                    @yield('content')
                </div>

            </div>

        </div>

    </div>
</body>

</html>
