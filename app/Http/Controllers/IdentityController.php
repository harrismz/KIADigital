<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\Job;
use App\Models\BloodType;
use App\Models\Mother;
use App\Models\Religion;

class IdentityController extends Controller
{
    public function getEducation() {
        $education = Education::all();

        // Mengecek apakah user ditemukan
        if ($education) {
            // Mengembalikan response jika education ditemukan
            $education = $education->sortBy('education_name');
            return response()->json($education, 200);
        } else {
            // Mengembalikan response jika education tidak ditemukan
            return response()->json(['message' => 'education not found.'], 404);
        }
    }

    public function getJob() {
        $jobs = Job::all();

        // Mengecek apakah user ditemukan
        if ($jobs) {
            // Mengembalikan response jika jobs ditemukan
            $jobs = $jobs->sortBy('job_name');
            return response()->json($jobs, 200);
        } else {
            // Mengembalikan response jika jobs tidak ditemukan
            return response()->json(['message' => 'jobs not found.'], 404);
        }
    }

    public function getBloodType() {
        $bloodTypes = BloodType::all();
        return response()->json($bloodTypes);
    }

    public function getReligion() {
        $religions = Religion::all();
        return response()->json($religions);
    }








    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $education = Education::all();

    //     // Mengecek apakah user ditemukan
    //     if ($education) {
    //         // Mengembalikan response jika education ditemukan
    //         $education = $education->sortBy('education_name');
    //         return response()->json($education, 200);
    //     } else {
    //         // Mengembalikan response jika education tidak ditemukan
    //         return response()->json(['message' => 'education not found.'], 404);
    //     }
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $rule = [
            'nik' => 'required|string', //size:16 Assuming NIK is a 16-character string
            'no_jkn' => 'required|string|max:20', // Assuming no_jkn is a string with a max length of 20
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
        ];

        $validated = $request->validate($rule);

        $mother = new Mother($validated);

        $mother->save();

        return [
            'success' => true,
            'message' => "Data saved!",
            'data' => $mother
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
