<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function createTag()
    {
        return response()->json('Ok mothefucker');
    }
}
