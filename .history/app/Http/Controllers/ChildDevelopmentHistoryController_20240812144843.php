<?php

namespace App\Http\Controllers;

use App\Models\ChildDevelopmentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChildDevelopmentHistoryController extends Controller
{
    /**
     * Get a list of blog posts with pagination and optional search query.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $childId)
    {
        // if childId is not provided, return error
        if (!$childId) {
            return response()->json([
                'error' => 'Child ID is required'
            ], 400);
        }
        // Get search query and current page
        $searchQuery = $request->input('search', '');
        $currentPage = $request->input('page', 1);
        $itemsPerPage = 5; // Define the number of items per page

        // Fetch child development history with optional search query
        $query = ChildDevelopmentHistory::with('child')
            ->where('child_id', $childId);

        if ($searchQuery) {
            $query->where('title', 'like', "%$searchQuery%")
                ->orWhere('body', 'like', "%$searchQuery%");
        }

        $totalItems = $query->count(); // Get total count of items

        $childDevelopmentHistories = $query->orderBy('created_at', 'desc')
            ->skip(($currentPage - 1) * $itemsPerPage)
            ->take($itemsPerPage)
            ->get();
        
        $chartData = DB::table('child')
        ->join ('child_development_history', 'child.id', '=', 'child_development_history.child_id')
        ->select(
                'child.id as child_id',
                'child.date_of_birth as dob', 
                'child.child_name as name',
                'child.gender as gender',
                'child.id as child_id',
                'child_development_history.height as height', 
                'child_development_history.weight as weight', 
                'child_development_history.head_circumference as head',
                'child_development_history.created_at as created_at')
        ->where('child.id', $childId)
        ->get();

        foreach ($chartData as $data) {

            if ($data->gender == 'Perempuan') {
                $heightData = DB::table('lhfa_girls')->get();
                $weightData = DB::table('wfl_girls')->get();
            }else{
                $heightlData = DB::table('lhfa_boys')->get();
                $weightData = DB::table('wfl_boys')->get();
            }

        }

        return response()->json([
            'chartData' => $chartData,
            'data' => $childDevelopmentHistories,
            'height' => $heightData,
            'weight' => $weightData,
            'total' => $totalItems
        ]);

    }

    public function showData($id) {
        $data = ChildDevelopmentHistory::with('child:id,child_name')->findOrFail($id);

        return [
            'success'=> true,
            'data' => $data
        ];
    }

    public function show($id)
    {
        // Find the data by id
        $data = ChildDevelopmentHistory::with('child')->where('id', $id)->first();

        // Calculate the age of the child in weeks and years
        $createdAt = $data->created_at;
        $dateOfBirth = $data->child->date_of_birth;

        $ageInWeeks = $createdAt->diffInWeeks($dateOfBirth);
        $ageInYears = $createdAt->diffInYears($dateOfBirth);

        // Calculate the age in years and weeks
        $years = floor($ageInWeeks / 52);
        $weeks = $ageInWeeks % 52;

        // Add the age information to the data
        $data->age = [
            'years' => $years,
            'weeks' => $weeks
        ];

        // Return the data as JSON response
        return response()->json($data);
    }

}
