<?php

namespace App\Http\Controllers;

use App\Models\Imunisation;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class ImunisasiController extends Controller
{
    //
    public function store(Request $request) {

        $validated = $request->validate([
            'child_id' => 'required',
            'staff_id' => 'nullable',
            'hospital_id' => 'nullable',
            'vaccine_id' => 'required',
            'date_vaccinated' => 'required|date',
        ]);

        $data = new Imunisation($validated);

        $data->save();

        return [
            'success' => true,
            'data' => $data,
            'message' => "Data Imunisasi Tersimpan!"
        ];
    }

    public function showVaccinePerChild(Request $request, $child_id ) {

        // get all Imunisation by child_id
        $imunisation = Imunisation::where('child_id', $child_id)
        ->with([
            'child:id,child_name', 'hospital:id,hospital_name', 'staff:id,staff_name', 'vaccine:id,vaccine_name'
        ])
        ->get();

        return [
            'data' => $imunisation,
            'success' => true
        ];

        // 
        
    }
}
