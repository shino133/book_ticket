@extends('layouts.layout')

@push('head')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
    <section class="page-header overlay-gradient"
        style="background: url({{ asset('images/branding/posters/movie-collection.webp') }});">
        <div class="container">
            <div class="inner">
                <h2 class="title">Phim</h2>
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li>Phim</li>
                </ol>
            </div>
        </div>
    </section>

    <!-- =============== BẮT ĐẦU PHẦN CHÍNH =============== -->
    <main class="ptb100">
        <div class="container" x-data="{
            layout: 'grid',
            setLayout(newLayout) {
                if (newLayout != 'grid' && newLayout != 'list') return;
                this.layout = newLayout;
                localStorage.setItem('layout', newLayout);
            },
            init() {
                const localLayout = localStorage.layout;
                if (localLayout == 'grid' || localLayout == 'list') {
                    this.layout = localLayout;
                } else {
                    this.layout = 'grid';
                }
            }
        }">

            <!-- Bắt đầu Bộ Lọc -->
            <div class="d-flex mb50 align-items-center justify-content-between">

                <form method="GET" action="{{ route('movies.index') }}" class="d-flex">

                    <input type="search" name="search" id="search" class="py-1 form-control" placeholder="search"
                        style="flex-basis: fit-content" value="{{ request('search') }}">

                    <div class="px-3 py-3 py-xl-0"></div>

                    <div class="d-flex align-items-center">
                        <label for="category" class="pr-1 text-nowrap">Thể loại:</label>
                        <select name="category" id="category" class="py-1">
                            <option value="" default>Tất cả thể loại</option>
                            @foreach (\App\Models\Category::CATEGORIES as $category)
                                <option value="{{ $category }}"
                                    {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="px-3 py-3 py-xl-0"></div>

                    <div class="d-flex align-items-center">
                        <label for="sort" class="pr-1 text-nowrap">Sắp xếp theo: </label>
                        @php
                            $sortings = [
                                'default' => 'Mặc định',
                                'top-rated' => 'Đánh giá cao',
                                'newest' => 'Mới nhất',
                                'oldest' => 'Cũ nhất',
                            ];
                        @endphp
                        <select name="sort" id="sort" class="py-1">
                            @foreach ($sortings as $value => $sorting)
                                <option value="{{ $value }}" {{ request('sort') == $value ? 'selected' : '' }}>
                                    {{ $sorting }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="px-2 py-3 py-xl-0"></div>

                    <input type="submit" value="Filter" class="btn btn-main">

                </form>

                <div class="py-3 py-xl-0"></div>

                <div>
                    <!-- Bộ Chuyển Đổi Giao Diện -->
                    <div class="layout-switcher">
                        <a href="#" class="list" x-bind:class="{ 'active': layout === 'list' }"
                            @@click.prevent="setLayout('list')">
                            <i class="fa fa-align-justify"></i>
                        </a>
                        <a href="#" class="grid" x-bind:class="{ 'active': layout === 'grid' }"
                            @@click.prevent="setLayout('grid')">
                            <i class="fa fa-th"></i>
                        </a>
                    </div>
                </div>

            </div>
            <!-- Kết thúc Bộ Lọc -->

            @if ($movies->isEmpty())
                <p class="bg-light font-weight-bold h4 p-5 rounded text-center">Không tìm thấy phim nào!</p>
            @else
                <!-- Bắt đầu Lưới Phim -->
                <div class="row" x-show="layout === 'grid'" x-transition>
                    @each('components.movie-grid-item', $movies, 'movie')
                </div>
                <!-- Kết thúc Lưới Phim -->

                <!-- Bắt đầu Danh Sách Phim -->
                <div class="row mt100" x-show="layout === 'list'" x-transition>
                    @each('components.movie-list-item', $movies, 'movie')
                </div>
                <!-- Kết thúc Danh Sách Phim -->
            @endif

            <!-- Bắt đầu Phân Trang -->
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    {!! $movies->links('pagination::bootstrap-4') !!}
                </div>
            </div>
            <!-- Kết thúc Phân Trang -->

        </div>
    </main>
    <!-- =============== KẾT THÚC PHẦN CHÍNH =============== -->
@endsection
