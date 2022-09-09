<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::all()->random();
        Auth::login($user);
        $token = $request->user()->createToken($request->user()->name);
        return response(['success' => true, 'token' => explode('|', $token->plainTextToken)[1]], 200);
    }


}
