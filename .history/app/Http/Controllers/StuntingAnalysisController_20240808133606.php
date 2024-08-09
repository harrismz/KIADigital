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

        $query = DB::table('child_development_history')
                        ->join('child', 'child_development_history.child_id', '=', 'child.id')
                        ->select(
                            'child.id as child_id', 
                            DB::raw('timestampdiff(MONTH, child.date_of_birth, NOW()) as age'), 
                            'child.child_name as name',
                            'child.gender as gender',
                            'child.id as child_id',
                            'child_development_history.height as height', 
                            'child_development_history.weight as weight', 
                            'child_development_history.created_at as created_at');

        $genderJoinTable = null;

        $queryResults = $query->get();

        foreach ($queryResults as $result) {
            if ($result->gender === 'Perempuan') {
                $genderJoinTable = 'lhfa_girls';
            } elseif ($result->gender === 'Laki-Laki') {
                $genderJoinTable = 'lhfa_boys';
            }
        
            if ($genderJoinTable) {
                $queryWithJoin = DB::table('child_development_history')
                    ->join('child', 'child_development_history.child_id', '=', 'child.id')
                    ->leftJoin($genderJoinTable, 'child.id', '=', "{$genderJoinTable}.child_id") // Adjust the join condition as needed
                    ->select(
                        'child.id as child_id', 
                        DB::raw('timestampdiff(MONTH, child.date_of_birth, NOW()) as age'), 
                        'child.child_name as name',
                        'child.gender as gender',
                        'child_development_history.height as height', 
                        'child_development_history.weight as weight', 
                        'child_development_history.created_at as created_at'
                    )
                    ->get();
        
                // Process your result here
            }
        }

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
