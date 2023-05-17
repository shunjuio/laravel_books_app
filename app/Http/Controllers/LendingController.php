<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LendingController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $bookId =  $request->get('book_id');

        $user->lendings()->create([
            'book_id' => $bookId,
            'start_at' => $request->get('start_at'),
            'end_at' =>$request->get('end_at'),
        ]);

        return redirect()->route('books.show', ['bookId'=> $bookId]);
    }

    public function show(int $lendingId)
    {
        $user = Auth::user();

        $lending = $user->lendings()
            ->where('id', $lendingId)
            ->first();
        $lending->book->image_path = Storage::url($lending->book->image_path);

        return view('lendings.show', compact('lending'));
    }

    public function update(Request $request, int $lendingId)
    {
        $user = Auth::user();
        $lending = $user->lendings()
            ->where('id', $lendingId)
            ->first();

        $lending->update([
            'is_returned' => 1,
        ]);

        return redirect()->route('books.show', ['bookId'=> $lending->book_id]);

    }
}
