<?php

namespace App\Http\Controllers\Token;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('token.index');
    }
}
