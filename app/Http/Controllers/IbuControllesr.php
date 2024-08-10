<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mother;

class IbuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($user_id)
    {
        $ibu = Mother::where('user_id', $user_id)->first();

        if ($ibu) {
            return response()->json($ibu);
        } else {
            return response()->json([
                'message' => 'Data ibu keluarga not found'
            ], 404);
        }
    }

    public function getWeek(Request $request) {

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
