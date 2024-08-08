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
                            'child.id as child_id', 
                            DB::raw('timestampdiff(MONTH, child.date_of_birth, NOW()) as age'), 
                            'child.child_name as name',
                            'child.gender as gender',
                            'child.id as child_id',
                            'child_development_history.height as height', 
                            'child_development_history.weight as weight', 
                            'child_development_history.created_at as created_at')
                        ->get();

        $finalData = [];

        foreach ($result as $data) {

            $childData = [
                'child_id' => $data->child_id,
                'age' => $data->age,
                'name' => $data->name,
                'gender' => $data->gender,
                'height' => $data->height,
                'weight' => $data->weight,
                'created_at' => $data->created_at
            ];

            if ($data->gender == 'Perempuan') {
                $additionalData = DB::table('lhfa_girls')->where('month', $data->age)->first();
            } else {
                $additionalData = DB::table('lhfa_boys')->where('month', $data->age)->first();
            }

            if ($additionalData) {
                $childData['additional_info'] = $additionalData; // Adjust this line if you need specific fields from `additionalData`
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Success",
            'data' => $finalData,
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
