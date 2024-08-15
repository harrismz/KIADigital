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
            'mother_id' => 'required',
            'father_id' => 'required',
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

    public function show(Request $request, $child_id) {

        $child = Child::with(['mother', 'father', 'bloodType'])->findOrFail($child_id);

        return [
            'success' => true,
            'data' => $child
        ];
    }

    public function update(Request $request, $child_id) {
        $rules = [
            'child_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'child_of' => 'nullable|integer|max:255',
            'akte_no' => 'nullable|string|max:100',
            'gender' => 'nullable|string|in:laki-laki,perempuan',
            'blood_type_id' => 'nullable|integer|exists:blood_type,id',
        ];

        $validated = $request->validate($rules);

        $child = Child::find($child_id);
        $child->update($validated);

        return [
            'success' => true,
            'data' => $child,
            'message' => "Data updated!"
        ];
    }
}
