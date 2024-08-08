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
            ->select(
                'child.id',  // Remove duplicate selection
                DB::raw('timestampdiff(MONTH, child.date_of_birth, NOW()) as age'),
                DB::raw('CASE WHEN child.gender = "Perempuan" THEN
                        (SELECT * FROM lhfa_girls WHERE lhfa_girls.month = timestampdiff(MONTH, child.date_of_birth, NOW()))
                    ELSE 
                        (SELECT * FROM lhfa_boys WHERE lhfa_boys.month = timestampdiff(MONTH, child.date_of_birth, NOW()))
                    END AS gender_specific_data'),
                'child.gender as child_gender',
                'child_development_history.height as height',
                'child_development_history.weight as weight',
                'child_development_history.created_at as created_at'
            )
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
