@extends('layouts.layout')

@section('content')
<section class="page-header overlay-gradient"
    style="background: url({{ asset('images/branding/posters/movie-collection.webp') }});">
    <div class="container">
        <div class="inner">
            <h2 class="title">Contact Us</h2>
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Contact Us</li>
            </ol>
        </div>
    </div>
</section>

<main class="contact-page ptb100">
    <div class="container">
        <div class="row">

            <!-- Bắt đầu phần Thông tin liên hệ -->
            <div class="col-md-4 col-sm-12">
                <h3 class="title">Thông tin</h3>

                <div class="details-wrapper">
                    <p>{{ config('app.name') }} là một hệ thống đặt vé dành cho rạp chiếu phim. Nó có rất nhiều tính năng, từ đặt vé thông thường đến phân quyền người dùng đa cấp. Hệ thống được phát triển bằng Laravel 8. Chúng tôi hy vọng bạn sẽ thích nó.</p>

                    @php
                    $url = preg_replace('#^https?://#', '', url('/'));
                    $email = 'info@' . $url;
                    @endphp

                    <ul class="contact-details">
                        <li>
                            <i class="icon-phone"></i>
                            <strong>Điện thoại:</strong>
                            <span>(123) 123-456 </span>
                        </li>
                        <li>
                            <i class="icon-printer"></i>
                            <strong>Fax:</strong>
                            <span>(123) 123-456 </span>
                        </li>
                        <li>
                            <i class="icon-globe"></i>
                            <strong>Website:</strong>
                            <span><a href="#">{{ $url }}</a></span>
                        </li>
                        <li>
                            <i class="icon-paper-plane"></i>
                            <strong>Email:</strong>
                            <span><a href="#">{{ $email }}</a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Kết thúc phần Thông tin liên hệ -->

            <!-- Bắt đầu phần Biểu mẫu liên hệ -->
            <div class="col-md-8 col-sm-12">
                <h3 class="title">Biểu mẫu liên hệ</h3>

                <!-- Bắt đầu biểu mẫu liên hệ -->
                <form id="contact-form">

                    <!-- Kết quả gửi biểu mẫu -->
                    <div id="contact-result"></div>
                    <!-- Kết thúc kết quả gửi biểu mẫu -->

                    <!-- Nhóm ô nhập -->
                    <div class="form-group">
                        <input class="form-control input-box" type="text" name="name" placeholder="Tên của bạn"
                            autocomplete="off">
                    </div>

                    <!-- Nhóm ô nhập -->
                    <div class="form-group">
                        <input class="form-control input-box" type="email" name="email" placeholder="Email của bạn"
                            autocomplete="off">
                    </div>

                    <!-- Nhóm ô nhập -->
                    <div class="form-group">
                        <input class="form-control input-box" type="text" name="subject" placeholder="Chủ đề"
                            autocomplete="off">
                    </div>

                    <!-- Nhóm ô nhập -->
                    <div class="form-group mb20">
                        <textarea class="form-control textarea-box" rows="8" name="message" placeholder="Nhập tin nhắn của bạn..."></textarea>
                    </div>

                    <!-- Nhóm nút gửi -->
                    <div class="form-group text-center">
                        <button class="btn btn-main btn-effect" type="submit">Gửi tin nhắn</button>
                    </div>
                </form>
                <!-- Kết thúc biểu mẫu liên hệ -->
            </div>
            <!-- Kết thúc phần Biểu mẫu liên hệ -->

        </div>
    </div>
</main>
@endsection