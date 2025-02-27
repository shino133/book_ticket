<div class="container">
    <h1 class="mt-0 mb-0">Vé đã đặt</h1>
    <hr>
    @if ($reservations->isNotEmpty())
        <table class="table table-responsive table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Phim</th>
                    <th scope="col">Ngày chiếu</th>
                    <th scope="col">Thời gian bắt đầu</th>
                    <th scope="col">Thời gian kết thúc</th>
                    <th scope="col">Số ghế</th>
                    <th scope="col">Giá vé</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            @foreach ($reservations as $reservation)
                <tr>
                    <th>{{ $reservation->show->movie->title }}</th>
                    <th>{{ $reservation->show->date->toDateString() }}</th>
                    <th>{{ $reservation->show->start_time->toTimeString() }}</th>
                    <th>{{ $reservation->show->end_time->toTimeString() }}</th>
                    <td>{{ $reservation->seat_number }}</td>
                    <td>{{ $reservation->show->price . ' ' . config('app.currency') }}</td>
                    @php
                        $canCancel = $reservation->show->date > now()->addHours(3);
                    @endphp

                    <td class="{{ $canCancel ? '' : 'disabled' }}">
                        @if ($canCancel)
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input class="btn btn-second text-white" type="submit" value="Cancel">
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="bg-light p-3 font-weight-bold rounded text-center">
            Bạn không có bất kỳ đặt chỗ nào trong tương lai.
        </div>
    @endif
</div>
