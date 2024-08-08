<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildDevelopmentHistory;
use Illuminate\Support\Facades\DB;

class StuntingAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $result = ChildDevelopmentHistory::all();

        $result = DB::table('child_development_history')
                        ->join('child', 'child_development_history.child_id', '=', 'child.id')
                        ->select('child.id as child_id', 'child.name as child_name', 'child.birth_date as child_birth_date', 'child.gender as child_gender')
                        // ->select('child_development_history.*', 'child.name as child_name', 'child.id as child_id', 'child.birth_date as child_birth_date', 'child.gender as child_gender')
                        ->get();

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
