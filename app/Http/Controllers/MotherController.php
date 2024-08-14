<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\Father;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotherController extends Controller
{
    public function show($id) {
        $data = Mother::find($id);

        return response()->json($data);
    }

    public function getFather(Request $request) {
        $mom_id = $request->mom_id;
        // query to get father's details
        $data = Father::with('kecamatan')
                ->with('religion')
                ->with('education')
                ->with('bloodType')
                ->with('job')
                ->where('mother_id',$mom_id)
                ->get();
        return response()->json($data);
    }
}
