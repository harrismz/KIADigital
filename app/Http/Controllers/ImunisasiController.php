<?php

namespace App\Http\Controllers;

use App\Models\Imunisation;
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
}
