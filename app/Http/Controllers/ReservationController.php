<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use PhpParser\Builder;

class ReservationController extends Controller
{
    public function index(){
      $user = Auth::user();
      $books = Book::whereHas('reservations', function ($query) use ($user) {
        $query->where('user_id', $user->id);
      })->get();


        return view('reservations.index', compact('user', 'books'));
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
