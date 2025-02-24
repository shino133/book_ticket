@extends('layouts.layout')

@section('content')
    <!-- =============== BẮT ĐẦU PHẦN GIỚI THIỆU CHI TIẾT PHIM =============== -->
    <section class="movie-detail-intro overlay-gradient ptb100"
        style="background: url({{ asset('images/branding/posters/movie-detail-bg.webp') }});">
    </section>
    <!-- =============== KẾT THÚC PHẦN GIỚI THIỆU CHI TIẾT PHIM =============== -->

    <!-- =============== BẮT ĐẦU PHẦN GIỚI THIỆU CHI TIẾT PHIM 2 =============== -->
    <section class="movie-detail-intro2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div class="movie-poster">
                        <img src="{{ asset('storage/' . $movie->image) }}" style="height: 440px" alt="">
                    </div>

                    <div class="movie-details">
                        <h3 class="title">{{ $movie->title }}</h3>

                        <ul class="movie-subtext">
                            <li>{{ $movie->maturity_rating }}</li>
                            <li>{{ $movie->running_time->format('G \h i\m\i\n') }}
                            </li>
                            <li>{{ $movie->category->title }}</li>
                            <li>{{ $movie->release_date->format('d M Y') }}</li>
                        </ul>

                        <a href="#reserve-now" class="btn btn-main btn-effect">Get tickets</a>
                        <a href="#" class="btn rate-movie"><i class="icon-heart"></i></a>

                        <div class="rating mt10">
                            @include('components.rating-stars', ['rating' => $movie->rating])
                            <span>{{ number_format($movie->rating, 1) }}/5</span>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </section>
    <!-- =============== KẾT THÚC PHẦN GIỚI THIỆU CHI TIẾT PHIM 2 =============== -->

    <!-- =============== BẮT ĐẦU PHẦN CHÍNH CHI TIẾT PHIM =============== -->
    <section class="movie-detail-main ptb100">
        <div class="container">

            <div class="row">
                <!-- Bắt đầu Phần Chính Phim -->
                <div class="col-lg-8 col-sm-12">
                    <div class="inner pr50">

                        <!-- Cốt truyện -->
                        <div class="storyline">
                            <h3 class="title">Storyline</h3>

                            <p>{{ $movie->storyline }}</p>
                        </div>

                        <!-- Xuất chiếu -->
                        <div class="movie-media mt50">
                            <h3 id="reserve-now" class="title">Reserve your ticket!</h3>
                            {{-- {{ ddd($shows->first()->date) }} --}}
                            @if ($shows->isNotEmpty())
                                <table class="table-responsive showtime-table table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Start time</th>
                                            <th scope="col">End time</th>
                                            <th scope="col">Ticket price</th>
                                            <th scope="col">Remaining seats</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    @foreach ($shows as $show)
                                        <tr class="{{ $show->remaining_seats < 5 ? 'table-danger' : '' }}">
                                            <th>{{ $show->date->toDateString() }}</th>
                                            <th>{{ $show->start_time->toTimeString() }}</th>
                                            <th>{{ $show->end_time->toTimeString() }}</th>
                                            <td>{{ $show->price . ' ' . config('app.currency') }}
                                            </td>
                                            <td>{{ $show->remaining_seats . '/' . $show->room->size }}
                                            </td>
                                            <td><a href="#reservation-popup"
                                                    class="btn btn-second btn-effect open-reservation-popup"
                                                    onclick="populateUI({{ $show->id . ',\'' . $show->date . '\',' . $show->price . ',' . (auth()->check() ? 'true' : 'false') }})">Reserve</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                @include('components.reservation-modal')
                            @else
                                <div class="bg-light p-3 font-weight-bold rounded text-center">
                                    Hiện tại không có suất chiếu nào cho bộ phim này, hãy quay lại sau!
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <!-- Kết thúc Phần Chính Phim -->

                <!-- Bắt đầu Sidebar -->
                <div class="col-lg-4 col-sm-12">
                    <div class="sidebar">

                        <!-- Bắt đầu Tiện ích Chi tiết Phim -->
                        <aside class="widget widget-movie-details">
                            <h3 class="title">Details</h3>

                            <ul>
                                <li><strong>Ngày phát hành:
                                    </strong>{{ $movie->release_date->toFormattedDateString() }}
                                </li>
                                <li><strong>Đạo diễn:
                                    </strong>{{ $movie->director }}</li>
                                <li><strong>Ngôn ngữ:
                                    </strong>{{ $movie->language }}</li>
                                <li><strong>Xếp hạng độ tuổi:
                                    </strong>{{ $movie->maturity_rating }}</li>
                                <li><strong>Thời lượng:
                                    </strong>{{ $movie->running_time->format('G \h i\m\i\n') }}
                                </li>
                            </ul>
                        </aside>
                        <!-- Kết thúc Tiện ích Chi tiết Phim -->

                    </div>
                </div>
                <!-- Kết thúc Sidebar -->
            </div>

        </div>
    </section>
    <!-- =============== KẾT THÚC PHẦN CHÍNH CHI TIẾT PHIM =============== -->

    <!-- =============== BẮT ĐẦU PHẦN PHIM ĐỀ XUẤT =============== -->
    <section class="recommended-movies bg-light ptb100">
        <div class="container">

            <!-- Bắt đầu hàng -->
            <div class="row">
                <div class="col-md-8 col-sm-12">
                    <h2 class="title">Những người thích phim này cũng thích...</h2>
                </div>
            </div>
            <!-- Kết thúc hàng -->

            <!-- Bắt đầu Thanh trượt Phim Mới -->
            <div class="owl-carousel recommended-slider mt20">
                @each('components.movie-item-image', $recommendations, 'movie')
            </div>
            <!-- Kết thúc Thanh trượt Phim Mới -->

        </div>
    </section>
    <!-- =============== KẾT THÚC PHẦN PHIM ĐỀ XUẤT =============== -->

    
@endsection
