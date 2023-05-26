<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    public function index()
    {
        $user         = Auth::user();
        $reservations = $user->reservations()->with('book')->get();

        return view('reservations.index', compact('user', 'reservations'));
    }

    public function show(Request $request, $reservationId)
    {
        $user                            = Auth::user();
        $reservation                     = $user->reservations()->where('id', $reservationId)->with('book')->firstOrFail();
        $reservation->display_image_path = Storage::url($reservation->book->image_path);
        $reservation->display_start_at   = Carbon::parse($reservation->start_at)->format('Y-m-d');
        $reservation->display_end_at     = Carbon::parse($reservation->end_at)->format('Y-m-d');

        return view('reservations.show', compact('reservation'));
    }

    public function store(StoreReservationRequest $request)
    {
        $user      = Auth::user();
        $validated = $request->validated();

        $user->reservations()->create([
            'book_id'  => $validated['book_id'],
            'start_at' => $validated['start_at'],
            'end_at'   => $validated['end_at'],
        ]);

        return redirect()->route('reservations.index');
    }

    public function destroy(Request $request, $reservationId)
    {
        Reservation::destroy($reservationId);

        return redirect()->route('reservations.index');
    }

}
