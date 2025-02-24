<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{



    public function store(Request $request)
    {
        $attr = $request->validate([
            'show_id' => ['required', Rule::exists(\App\Models\Show::class, 'id')],
            'selected_seats' => ['array'],
        ]);

        // create the reservations of the requested seats
        foreach ($attr['selected_seats'] as $seat) {
            Reservation::create([
                'show_id' => $attr['show_id'],
                'user_id' => Auth::id(),
                'seat_number' => $seat,
            ]);
        }

        // decrement the remaining_seats of the specific show
        $show = Show::find($attr['show_id']);
        $show->remaining_seats = $show->remaining_seats - sizeof($attr['selected_seats']);
        $show->save();

        // return success
    }


    public function destroy(Reservation $reservation)
    {
        // increment show's remaining seats
        $reservation->show->remaining_seats++;
        $reservation->show->save();

        // delete reservation itself from db
        $reservation->delete();

        return redirect('dashboard')->with([
            'flash' => 'success',
            'message' => 'Hủy đặt chỗ thành công. Bạn sẽ được hoàn lại số tiền vé.',
        ]);
    }
}
