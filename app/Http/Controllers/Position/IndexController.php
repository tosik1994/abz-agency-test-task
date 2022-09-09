<?php

namespace App\Http\Controllers\Position;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke()
    {
        return view('position.index');
    }
}
