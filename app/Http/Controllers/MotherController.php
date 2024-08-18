<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\Father;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotherController extends Controller
{
    public function show($id) {
        $data = Mother::find($id);

        return response()->json($data);
    }

    public function getFather(Request $request) {
        $mom_id = $request->mom_id;
        // query to get father's details
        $data = Father::with('kecamatan')
                ->with('religion')
                ->with('education')
                ->with('bloodType')
                ->with('job')
                ->where('mother_id',$mom_id)
                ->get();
        return response()->json($data);
    }

     public function update(Request $request, $id) {
        //
        $rule = [
            'nik' => 'required', //size:16 Assuming NIK is a 16-character string
            'no_jkn' => 'required|max:20', // Assuming no_jkn is a string with a max length of 20
            'name' => 'required|string|max:255', // Name should be a string with a max length of 255
            'date_of_birth' => 'required|date', // date_of_birth should be a valid date
            'birth_place' => 'nullable|string|max:255', // birth_place is optional, string with max length of 255
            'phone_number' => 'nullable|string|max:15', // phone_number is optional, string with max length of 15
            'address' => 'nullable|string|max:500', // address is optional, string with max length of 500
            'kecamatan_id' => 'nullable|integer|exists:kecamatan,id', // Assuming it references an ID in the kecamatans table
            'religion_id' => 'nullable|integer|exists:religion,id', // Assuming it references an ID in the religions table
            'education_id' => 'nullable|integer|exists:education,id', // Assuming it references an ID in the educations table
            'blood_type_id' => 'nullable|integer|exists:blood_type,id', // Assuming it references an ID in the blood_types table
            'job_id' => 'nullable|integer|exists:job,id', // Assuming it references an ID in the jobs table
            'height' => 'nullable|numeric|min:0|max:300', // height is optional, should be a number between 0 and 300 cm
            'user_id' => 'nullable|integer|exists:users,id', // Assuming it references an ID in the users table
            'mother_id' => 'nullable|integer|exists:users,id', // Assuming it references an ID in the users table
        ];

        $validated = $request->validate($rule);

        $mother = Mother::find($id);
        $mother->update($validated);

        return [
            'success' => true,
            'message' => "Data updated!",
            'data' => $mother
        ];

    }
}
