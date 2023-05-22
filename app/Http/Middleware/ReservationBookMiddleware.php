<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ReservationBookMiddleware
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

        $reservation = $user->reservations()
            ->where('book_id', $bookId)
            ->first();

        if ($reservation)
        {
            return redirect()->route('reservations.show',['reservationId' => $reservation->id]);
        }
        return $next($request);
    }
}
