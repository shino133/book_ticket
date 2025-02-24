<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\View\View;


class UserController extends Controller
{
    public function store(Request $request)
    {
        // Chỉ lấy các vai trò cần thiết để tối ưu hóa truy vấn
        $roles = Role::whereIn('code', [Role::MANAGER_CODE, Role::CUSTOMER_CODE])->get();
        $validRoles = $roles->pluck('id');

        // Xác thực dữ liệu đầu vào
        $fields = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'role_id' => ['required', Rule::in($validRoles)],
        ]);

        // Xác định xem người dùng có muốn làm quản lý không
        $wantsManager = $fields['role_id'] == $roles->where('code', Role::MANAGER_CODE)->first()?->id;
        $fields['wants_manager'] = $wantsManager;

        // Nếu không muốn làm quản lý, gán vai trò mặc định là khách hàng
        if (! $wantsManager) {
            $fields['role_id'] = $roles->where('code', Role::CUSTOMER_CODE)->first()?->id;
        }

        // Tạo người dùng
        $user = User::create($fields);

        Mail::to($user->email)->queue(new WelcomeMail($user));

        // Đăng nhập user
        Auth::login($user);

        return redirect()->route('home')->with([
            'flash' => 'success',
            'message' => $user->wants_manager
                ? "Account created, you will remain a customer until administration's approval."
                : "Your account has been successfully created!",
        ]);
    }


    public function dashboard(): View
    {
        $user = Auth::user();
        /**
         *  @var User $user
         */
        $user->load(['reservations.show.movie']);

        return view('user.user-dashboard', [
            'user' => $user,
            'reservations' => $user->reservations->where('show.date', '>', now()),
        ]);
    }
}
