<div class="container">
    <h1 class="mt-0 mb-0">Chỉnh Sửa thông tin cá nhân</h1>
    <hr>
    <div class="row">
        <!-- Cột trái -->
        <div class="col-md-3">
            <div class="text-center">
                <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
                <h6>Tải ảnh khác lên...</h6>

                <input type="file" class="form-control">
            </div>
        </div>

        <!-- Cột chỉnh sửa thông tin -->
        <div class="col-md-9 personal-info">
            <h3 class="mt-0">Thông Tin Cá Nhân</h3>

            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Tên:</label>
                    <div class="col-lg-8">
                        <input name="first_name" class="form-control" type="text" value="{{ $user->first_name }}">
                        @include('components.error-message',['field_name' => 'first_name'])
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Họ:</label>
                    <div class="col-lg-8">
                        <input name="last_name" class="form-control" type="text" value="{{ $user->last_name }}">
                        @include('components.error-message',['field_name' => 'last_name'])
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input name="email" class="form-control" type="text" value="{{ $user->email }}">
                        @include('components.error-message',['field_name' => 'email'])
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Tên người dùng:</label>
                    <div class="col-md-8">
                        <input readonly class="form-control" type="text" value="{{ $user->username }}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Mật khẩu:</label>
                    <div class="col-md-8">
                        <input name="password" class="form-control" type="password">
                        @include('components.error-message',['field_name' => 'password'])
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label">Xác nhận mật khẩu:</label>
                    <div class="col-md-8">
                        <input name="password_confirmation" class="form-control" type="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="button" class="btn btn-primary" value="Lưu Thay Đổi">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Hủy">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>