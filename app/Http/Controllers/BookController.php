<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $books = Book::all();

        return view('books.index', compact('user', 'books'));
    }

    public function show(int $bookId)
    {
        $book = Book::with([
            'reservations' => function ($query) {
                $query->orderBy('start_at', 'asc');
            }
        ])->find($bookId);

        $book->image_path = Storage::url($book->image_path);

        $isLending = $book->nowlending ? true : false;
        foreach ($book->reservations as $reservation) {
            $reservation->display_start_at = Carbon::parse($reservation->start_at)->format('Y-m-d');
            $reservation->display_end_at   = Carbon::parse($reservation->end_at)->format('Y-m-d');
        }

        return view('books.show', compact('book', 'isLending'));
    }
}
