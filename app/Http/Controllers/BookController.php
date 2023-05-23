<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $books = Book::all();

        return view('books.index', compact('user', 'books'));
    }

    public function show(int $bookId)
    {
        $book = Book::with('reservations')->find($bookId);
        $book->image_path = Storage::url($book->image_path);

        $isLending = $book->nowlending ? true : false;

        return view('books.show', compact('book', 'isLending'));
    }
}
