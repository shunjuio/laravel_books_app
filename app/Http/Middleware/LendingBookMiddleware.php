<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LendingBookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $bookId = $request->route('bookId');
        $lending = $user->lendings()
            ->where('book_id', $bookId)
            ->where('is_returned', 0)
            ->first();
        //自分が貸出中なら貸出詳細へリダイレクト
        if ($lending)
        {
            return redirect()->route('books.index');
        }
        return $next($request);
    }
}
