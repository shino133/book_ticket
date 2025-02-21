@extends('admin.layout')

@section('content')
<h1 class="h3 mb-4 text-gray-800">Người sử dụng</h1>
@if ($users->isNotEmpty())
<table class="showtime-table table table-striped table-hover rounded">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Tên người dùng</th>
            <th scope="col">Vai trò</th>
            <th scope="col">Email</th>
            <th scope="col"></th>
        </tr>
    </thead>
    @foreach ($users as $user)
    <tr>
        <th>{{ $user->username }}</th>
        <td>{{ $user->role->title }}</td>
        <td>{{ $user->email }}</td>
        @if (!$user->isAdmin())
        <td class="">
            <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                @csrf
                @method('delete')
                <input class="btn btn-danger text-white" type="submit" value="Delete User">
            </form>
        </td>
        @else
        <td class="">
            <button class="btn btn-danger text-white disabled" type="button">Xóa người dùng</button>
        </td>
        @endif
    </tr>
    @endforeach
</table>
@else
<div class="bg-light p-3 font-weight-bold rounded text-center">
Hiện tại không có người dùng
</div>
@endif
@include('components.flash-message')
@endsection