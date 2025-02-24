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
        $roles = Role::all();
        $validRoles = $roles->whereNotIn('code', [Role::ADMIN_CODE])->pluck('id');

        $fields = $request->validate([
            'first_name' => ['required', 'max:255'],
            'last_name' => ['nullable', 'max:255'],
            'username' => ['required', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'role_id' => ['required', Rule::in($validRoles)],
        ]);

        // Kiểm tra nếu người dùng muốn làm quản lý
        $fields['wants_manager'] = $fields['role_id'] == $roles->where('code', Role::MANAGER_CODE)->first()?->id;

        // Gán role mặc định là khách hàng
        $fields['role_id'] = $roles->where('code', Role::CUSTOMER_CODE)->first()?->id;

        // Tạo user và gửi mail
        $user = User::create($fields);
        Mail::to($user)->send(new WelcomeMail($user));

        // Đăng nhập user
        Auth::login($user);

        return redirect('/')->with([
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
