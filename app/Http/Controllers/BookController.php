<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function show(int $bookId)
    {
        $book = Book::where('id', $bookId)->first();
        $book->image_path = Storage::url($book->image_path);

        $isLending = $book->nowlending ? true : false;

        return view('books.show', compact('book', 'isLending'));
    }
}
