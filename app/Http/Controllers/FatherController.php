<?php

namespace App\Http\Controllers;
use App\Models\Father;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FatherController extends Controller
{
    public function show($id) {
        $data = Father::find($id);

        return response()->json($data);
    }
}
