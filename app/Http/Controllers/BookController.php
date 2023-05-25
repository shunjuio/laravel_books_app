<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Lending;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $books = Book::all();

        //現在借りています（自分の借りている本）
        $isLendings = $user->nowLendings()
            ->with('book')
            ->get();
        $isLendingList = $isLendings->pluck('book_id')->all();

        //予約しています（自分が予約している本）
        $isReservatioins = $user->reservations()
            ->with('book')
            ->get();
        $isReservatioinList = $isReservatioins->pluck('book_id')->all();

        //貸出中（他のユーザーが借りている本）
        $otherLendings = Lending::where('user_id', '!=', $user->id)->where('is_returned', 0)->with('book')->get();
        $otherLendingList = $otherLendings->pluck('book_id')->all();

//        　貸出可能（貸出していない＆他の人の予約はある場合もある本）
        $status = [];
        foreach ($books as $book) {
            if (in_array($book->id, $isLendingList)) {
                $status[$book->id] = '現在借りています';
            } elseif (in_array($book->id, $otherLendingList)) {
                $status[$book->id] = '貸出中';
            } elseif (in_array($book->id, $isReservatioinList)) {
                $status[$book->id] = '予約しています';
            } else {
                $status[$book->id] = '貸出可能';
            }
        }

        return view('books.index', compact('user', 'books', 'status'));
    }

    public function show(int $bookId)
    {
        $book = Book::where('id', $bookId)->first();
        $book->image_path = Storage::url($book->image_path);

        $isLending = $book->nowlending ? true : false;

        return view('books.show', compact('book', 'isLending'));
    }
}
