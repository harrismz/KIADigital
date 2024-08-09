<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildDevelopmentHistory;
use dd;

class StuntingAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = ChildDevelopmentHistory::all();

        print_r($result);

        return response()->json([
            'success' => true,
            'message' => "Success",
            'data' => $result
        ], 200);
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
