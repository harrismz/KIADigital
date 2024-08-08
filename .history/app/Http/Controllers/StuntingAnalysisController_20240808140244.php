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
                'created_at' => date('M-Y', strtotime($data->created_at)),
            ];

            if ($data->gender == 'Perempuan') {
                $additionalData = DB::table('lhfa_girls')->where('month', $data->age)->first();
                $statusLhfa = $this->getStuntingAnalysis($data->height, $additionalData);
            } else {
                $additionalData = DB::table('lhfa_boys')->where('month', $data->age)->first();
                $statusLhfa = $this->getStuntingAnalysis($data->height, $additionalData);
            }

            if ($statusLhfa) {
                $childData['status_lhfa'] = $additionalData; 
            }

            $finalData[] = $childData;
        }
        
        return response()->json([
            'success' => true,
            'message' => "Success",
            'data' => $finalData,
        ], 200);
    }

    private function getStuntingAnalysis($height, $lhfa) {
        // =IF(H<=sd3neg,"Stunting",IF(H<sd2neg,"Stunting",IF(H>=sd2neg,"Normal", IF(H>sd3,"Normal", "Unidentified"))))
        if($height <= $lhfa->sd3neg || $height < $lhfa->sd2neg) {
            return "Stunting";
        }

        if($height >= $lhfa->sd2neg || $height > $lhfa->sd3) {
            return "Normal";
        }

        return "Unidentified";
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
