<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class VaksinController extends Controller
{
    //
    public function combo(Request $request) {
        // 
        $data = Vaccine::select([
            'id as value',
            'vaccine_name as key'
        ])->get();

        return [
            'success' => true,
            'data' => $data
        ];
    }
}
