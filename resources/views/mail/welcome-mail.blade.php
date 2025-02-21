@component('mail::message')
# Chào mừng bạn đến với {{ config('app.name') }}

Xin chào {{ $user->first_name }},

@if( $user->wants_manager )
Cảm ơn bạn đã đăng ký. Vui lòng chờ quản trị viên phê duyệt tài khoản quản lý của bạn. Trong thời gian chờ đợi, tài khoản của bạn sẽ được sử dụng như một tài khoản khách hàng.<br>
Bạn sẽ nhận được email khi tài khoản được phê duyệt.<br>
Bạn có thể thử đăng nhập bằng liên kết dưới đây.<br>
@else
Cảm ơn bạn đã đăng ký, tài khoản của bạn đã được tạo thành công.<br>
Bây giờ bạn có thể đăng nhập bằng liên kết dưới đây.<br>
@endif

@component('mail::button', ['url' => config('app.url').'/login'])
Đăng nhập
@endcomponent

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent