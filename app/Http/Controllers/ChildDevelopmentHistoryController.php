<?php

namespace App\Http\Controllers;

use App\Models\ChildDevelopmentHistory as ModelsChildDevelopmentHistory;
use Illuminate\Http\Request;

class ChildDevelopmentHistoryController extends Controller
{
    /**
     * Get a list of blog posts with pagination and optional search query.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $childId = $request->input('child_id');
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
        $query = ModelsChildDevelopmentHistory::query()
            ->where('child_id', $childId);

        if ($searchQuery) {
            $query->where('title', 'like', "%$searchQuery%")
                ->orWhere('body', 'like', "%$searchQuery%");
        }

        $totalItems = $query->count(); // Get total count of items

        $blogPosts = $query->orderBy('created_at', 'desc')
            ->skip(($currentPage - 1) * $itemsPerPage)
            ->take($itemsPerPage)
            ->get();

        return response()->json([
            'data' => $blogPosts,
            'total' => $totalItems
        ]);
    }

    public function showData($id) {
        $data = ModelsChildDevelopmentHistory::with('child:id,child_name')->findOrFail($id);
        
        return [
            'success'=> true,
            'data' => $data
        ];
    }

    public function show($id)
    {
        // Find the data by id
        $data = ModelsChildDevelopmentHistory::where('id', $id)->first();

        // Return the data as JSON response
        return response()->json($data);
    }
}
