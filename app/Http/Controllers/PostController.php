<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Get a list of blog posts with pagination and optional search query.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Get search query and current page
        $searchQuery = $request->input('search', '');
        $currentPage = $request->input('page', 1);
        $itemsPerPage = 5; // Define the number of items per page

        // Fetch blog posts with optional search query
        $query = Post::query();

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

    public function show($slug)
    {
        // Find the blog by slug
        $blog = Post::where('slug', $slug)->first();

        // Return the blog as JSON response
        return response()->json($blog);
    }
}
