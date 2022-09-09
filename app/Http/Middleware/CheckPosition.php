<?php

namespace App\Http\Middleware;

use App\Models\Position;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CheckPosition
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $positionNotFound = ["success" => false,
            "message" => "Position not found"];

        if (Position::all()->count() == 0) {
            return response($positionNotFound, 422);
        }

        return $next($request);
    }
}
