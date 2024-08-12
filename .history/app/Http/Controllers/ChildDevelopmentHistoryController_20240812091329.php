<?php

namespace App\Http\Controllers;

use App\Models\ChildDevelopmentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return response()->json([
            'data' => $childDevelopmentHistories,
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
