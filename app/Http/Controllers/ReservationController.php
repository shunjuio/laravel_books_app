<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use PhpParser\Builder;

class ReservationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reservations = Reservation::with('book')->where('user_id', $user->id)->get();

        return view('reservations.index', compact('user', 'reservations'));
    }

    public function store(Request $request)
    {
      $user = Auth::user();
      $bookId =  $request->get('book_id');

      $user->reservations()->create([
        'book_id' =>$bookId,
        'start_at' => $request->get('start_at'),
        'end_at' => $request->get('end_at')
      ]);

      return redirect()->route('reservations.index');
    }

}
