<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryDebugController extends Controller
{
    public function debug()
    {
        return response()->json(['message' => 'Debug Endpoint']);
    }
}
