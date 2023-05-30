<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Lending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $books = Book::with('tags')->get();

        //現在借りています(自分が借りている本)
        $lendingBookIdList = $user->nowLendings()->with('book')->pluck('book_id')->all();

        //予約しています（自分が予約している本）
        $reservationBookIdList = $user->reservations()->with('book')->pluck('book_id')->all();

        
        //貸出中（他のユーザーが借りている本）
        $otherLendingBookIdList = Lending::where('user_id', '!=', $user->id)->where('is_returned', 0)->with('book')->pluck('book_id')->all();

        $status = [];
        foreach ($books as $book) {
            if (in_array($book->id, $lendingBookIdList)) {
                $status[$book->id] = '現在借りています';
            } elseif (in_array($book->id, $otherLendingBookIdList)) {
                $status[$book->id] = '貸出中';
            } elseif (in_array($book->id, $reservationBookIdList)) {
                $status[$book->id] = '予約しています';
            } else {
                $status[$book->id] = '貸出可能';
            }
        }

        return view('books.index', compact('user', 'books', 'status'));
    }

    public function show(int $bookId)
    {
        $book = Book::with([
            'reservations' => function ($query) {
                $query->orderBy('start_at');
            },
            'nowlending',
        ])->find($bookId);

        $book->image_path   = Storage::url($book->image_path);
        $book->default_date = Carbon::today()->format('Y-m-d');

        $isLending = $book->nowlending ? true : false;
        foreach ($book->reservations as $reservation) {
            $reservation->display_start_at = Carbon::parse($reservation->start_at)->format('Y-m-d');
            $reservation->display_end_at   = Carbon::parse($reservation->end_at)->format('Y-m-d');
        }

        return view('books.show', compact('book', 'isLending'));
    }
}
