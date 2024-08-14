<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    //
    public function store(Request $request) {
        $rules = [
            'child_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'child_of' => 'nullable|integer|max:255',
            'akte_no' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:laki-laki,perempuan', // Adjust options as needed
            'blood_type_id' => 'nullable|integer|exists:blood_type,id', // Assuming you have a blood_types table
        ];

        $validated = $request->validate($rules);

        $child = new Child($validated);
        $child->save();

        return [
            'success' => true,
            'data' => $child,
            'message' => "Data saved!"
        ];

    }
}
