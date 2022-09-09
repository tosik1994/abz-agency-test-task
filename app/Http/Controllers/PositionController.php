<?php

namespace App\Http\Controllers;

use App\Models\Position;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ['success' => true, 'positions' => Position::all()];
    }

}
