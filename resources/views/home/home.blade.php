@extends('layouts.layout')

@section('content')
    @include('home.hero-slider')

    <!-- =============== START OF TOP MOVIES SECTION =============== -->
    <section class="top-movies2">
        <div class="container">
            <div class="row">
                @php
                    $containerClasses = ['col-sm-6 col-xs-12', 'col-sm-6 d-none d-sm-block', 'd-none d-lg-block', 'd-none d-lg-block'];
                @endphp
                @foreach ($top4movies as $movie)
                    @include('components.movie-item-dark', [
                        'movie' => $movie,
                        'containerClass' => $containerClasses[$loop->index],
                    ])
                @endforeach
            </div>
        </div>
    </section>
    <!-- =============== END OF TOP MOVIES SECTION =============== -->

    <!-- =============== START OF HOW IT WORKS SECTION =============== -->
    <section class="how-it-works4 pt50 pb100">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="title">Nó hoạt động thế nào?</h2>
                    <h6 class="subtitle">Bạn có cảm thấy bối rối không? Hãy bắt đầu tại đây.</h6>
                </div>
            </div>

            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <div class="icon-box2">
                        <i class="fa fa-film"></i>
                        <h4 class="title">Chọn phim của bạn</h4>
                        <p>Duyệt qua bộ sưu tập phim phong phú và hấp dẫn của chúng tôi. Vẫn không biết nên xem gì? hãy xem <a href={{ route('movies.index') }} class="text-primary">khuyến nghị.</a></p>
                    </div>

                    <div class="icon-box2">
                        <i class="fa fa-ticket"></i>
                        <h4 class="title">Đặt vé của bạn</h4>
                        <p>Đặt vé xem phim yêu thích của bạn!</p>
                    </div>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="icon-box2">
                        <i class="icon-login"></i>
                        <h4 class="title">Đăng ký</h4>
                        <p>Đăng ký tài khoản của bạn để đặt chỗ và thanh toán vé. Ngoài ra, để cập nhật các ưu đãi và tin tức mới nhất.</p>
                    </div>

                    <div class="icon-box2">
                        <i class="icon-heart"></i>
                        <h4 class="title">Thưởng thức!</h4>
                        <p>Hãy thưởng thức bộ phim của bạn tại một trong những phòng chiếu phim của chúng tôi, hãy gọi đồ ăn nhẹ khi bạn đang ở đó. Sự tiện lợi của bạn là ưu tiên hàng đầu của chúng tôi.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- =============== END OF HOW IT WORKS SECTION =============== -->

    <!-- =============== START OF LATEST RELEASES SECTION =============== -->
    <section class="latest-releases bg-light ptb100">
        <div class="container">

            <!-- Start of row -->
            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="title">Phim Mới Nhất</h2>
                    <h6 class="subtitle">Xem bộ sưu tập phim mới nhất của chúng tôi.</h6>
                </div>
            </div>
            <!-- End of row -->
        </div>
        <!-- End of Container -->

        <!-- Start of Latest Releases Slider -->
        <div class="owl-carousel latest-releases-slider">
            @each('components.movie-item', $newest_movies, 'movie')
        </div>
        <!-- End of Latest Releases Slider -->

        <div class="text-center pt-3">
            <a class="btn btn-main btn-effect" href="{{ route('movies.index') }}">Xem tất cả phim</a>
        </div>
    </section>
    <!-- =============== END OF LATEST RELEASES SECTION =============== -->

    <!-- =============== START OF FEATURES SECTION =============== -->
    <section class="features">
        <div class="row">

            <div class="col-md-6 col-sm-12 with-bg overlay-gradient"
                style="background: url({{ asset('images/other/people-cinema.jpg') }})"></div>

            <div class="col-md-6 col-sm-12 bg-white">
                <div class="features-wrapper">
                    <h3 class="title">Xem tất cả những bộ phim mới nhất ngay khi chúng được phát hành!</h3>
                    @guest
                        <p>Đăng ký hoặc đăng ký ngay để đặt vé cho riêng bạn. Và nhận thông báo về các ưu đãi và tin tức mới!</p>
                        <a class="btn btn-main btn-effect" href="{{ route('register') }}">Đăng Ký</a>
                    @endguest

                    @auth
                        <p>Hãy bắt đầu đặt vé để thưởng thức những bộ phim mới nhất và hay nhất!</p>
                        <a class="btn btn-main btn-effect" href="{{ route('movies.index') }}">Hiển thị</a>
                    @endauth
                </div>
            </div>

        </div>
    </section>
    <!-- =============== END OF FEATURES SECTION =============== -->

    <!-- =============== END OF SUBSCRIBE SECTION =============== -->
    <section class="subscribe bg-light2 ptb100">
        <div class="container">

            <!-- Start of row -->
            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    @guest
                        <h2 class="title">Tham gia Cinemat ngay!</h2>
                        <h6 class="subtitle">Nhập email của bạn để được thông báo về bất kỳ tin tức và ưu đãi mới nào!</h6>
                    @endguest

                    @auth
                        <h2 class="title">Cảm ơn vì đã sử dụng {{ config('app.name') }}!</h2>
                        <h6 class="subtitle">Chúng tôi hy vọng bạn có trải nghiệm thú vị khi hợp tác với chúng tôi!</h6>
                    @endauth
                </div>
            </div>
            <!-- End of row -->


            @guest
                <!-- Start of row -->
                <div class="row justify-content-center">
                    <div class="col-md-7 col-sm-10 col-12">

                        <!-- Subscribe Form -->
                        <form method="POST" action="{{ route('leads') }}" class="mt50">
                            @csrf
                            <!-- Form -->
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control" id="email"
                                        placeholder="Your Email" autocomplete="off">
                                    <label for="email"></label>
                                    <button type="submit" class="btn btn-main btn-effect">Đặt mua</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- End of row -->
            @endguest


        </div>
    </section>
    @include('components.flash-message')
    <!-- =============== END OF SUBSCRIBE SECTION =============== -->
@endsection
