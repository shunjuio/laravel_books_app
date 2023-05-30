<?php

namespace App\Http\Controllers;

use App\Http\Requests\LendingRequest;
use App\Jobs\SendLendingRemindMailJob;
use App\Mail\SendLendingRemindMail;
use App\Models\Lending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class LendingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $lendings = $user->nowLendings()
            ->with('book')
            ->get()
            ->sortBy('end_at');

        return view('lendings.index', compact('user', 'lendings'));

    }

    public function store(LendingRequest $request)
    {
        $user   = Auth::user();
        $bookId = $request->get('book_id');

        $user->lendings()->create([
            'book_id'  => $bookId,
            'start_at' => $request->get('start_at'),
            'end_at'   => $request->get('end_at'),
        ]);

        return redirect()->route('books.show', ['bookId' => $bookId]);
    }

    public function show(int $lendingId)
    {
        $today = Carbon::today();

        $user                      = Auth::user();
        $lending                   = $user->lendings()
            ->where('id', $lendingId)
            ->first();
        $lending->book->image_path = Storage::url($lending->book->image_path);

        return view('lendings.show', compact('lending', 'today'));
    }

    public function update(Request $request, int $lendingId)
    {
        $user    = Auth::user();
        $lending = $user->lendings()
            ->where('id', $lendingId)
            ->first();

        $lending->update([
            'is_returned' => 1,
        ]);

        return redirect()->route('books.show', ['bookId' => $lending->book_id]);

    }

}
