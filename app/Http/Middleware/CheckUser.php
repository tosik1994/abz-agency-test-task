<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use http\Params;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $userMustBeInteger = ["success" => false,
            "message" => "Validation failed",
            "fails" => ["user_id" => ["The user_id must be an integer."]]];

        $userNotFound = ["success" => false,
            "message" => "The user with the requested identifier does not exist",
            "fails" => ["user_id" => ["User not found"]]];

//        $pagesValidatedMessages = validator($request->all(), [
//            'pages' => 'integer|min:1',
//        ])->errors()->messages();


        $userIdValidatedMessages = validator($request->route()->parameters, [
            'user' => 'integer',
        ])->errors()->messages();

        if (Arr::get($userIdValidatedMessages, 'user')) {
            return response($userMustBeInteger, 400);
        } elseif (Arr::get($request->route()->parameters, 'user') && !User::find($request->route('user'))) {
            return response($userNotFound, 404);
        }

//        if (Arr::get($pagesValidatedMessages, 'pages')) {
//            return response($pagesValidatedMessages, 400);
//        }

        return $next($request);
    }
}
