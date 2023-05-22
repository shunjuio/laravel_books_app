<?php

namespace App\Http\Middleware;

use App\Models\Reservation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DeleteExpiredReservationsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = date('Y-m-d');
        $result = Reservation::where('start_at', '<', $today)->delete();
        Log::debug($result);
        return $next($request);
    }
}
