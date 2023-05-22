<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use PhpParser\Builder;

class ReservationController extends Controller
{
    public function index()
    {
        $user         = Auth::user();
        $reservations = $user->reservations()->with('book')->where('user_id', $user->id)->get();

        return view('reservations.index', compact('user', 'reservations'));
    }

    public function show(Request $request, $reservationId)
    {
        $user                            = Auth::user();
        $reservation                     = $user->reservations()->where('id', $reservationId)->with('book')->first();
        $reservation->display_image_path = Storage::url($reservation->book->image_path);
        $reservation->display_start_at   = Carbon::parse($reservation->start_at)->format('Y-m-d');
        $reservation->display_end_at     = Carbon::parse($reservation->end_at)->format('Y-m-d');

        return view('reservations.show', compact('reservation'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_at' =>  'required|date|after_or_equal:today',
            'end_at' => 'required|date|after:start_at',
        ]);

        $user   = Auth::user();
        $bookId = $request->get('book_id');
        $user->reservations()->create([
            'book_id'  => $bookId,
            'start_at' => $request->get('start_at'),
            'end_at'   => $request->get('end_at')
        ]);

        return redirect()->route('reservations.index');
    }

    public function destroy(Request $request, $reservationId)
    {
        Reservation::destroy($reservationId);

        return redirect()->route('reservations.index');
    }

}
