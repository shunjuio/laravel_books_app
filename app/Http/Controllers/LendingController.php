<?php

namespace App\Http\Controllers;

use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
