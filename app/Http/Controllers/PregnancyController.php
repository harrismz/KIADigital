<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use App\Models\Pregnancy;
use Illuminate\Http\Request;
use DateTime;
class PregnancyController extends Controller
{
    //
    public function store(Request $request) {
        $rule = [
            // 'id' => 'nullable|integer',
            'mother_id' => 'required|integer',
            'first_day_of_last_period' => 'required|date',
            'estimate_date_of_delivery' => 'nullable|date',
            'upper_arm_circumference' => 'nullable|numeric',
            'kek' => 'nullable|string',
            'contraception_id' => 'nullable|integer',
            'pregnancy_number' => 'nullable|integer',
            'number_of_deliveries' => 'nullable|integer',
            'number_of_miscarriages' => 'nullable|integer',
            'number_of_living_children' => 'nullable|integer',
            'number_of_deceased_children' => 'nullable|integer',
            'number_of_premature_children' => 'nullable|integer',
            'interval_of_last_delivery' => 'nullable|integer',
            'tetanus_immunization' => 'nullable|string',
            'last_delivery_helper' => 'nullable|string',
            'last_delivery_method' => 'nullable|string',
            // 'created_at' => 'nullable|date',
            // 'updated_at' => 'nullable|date',
        ];

        $validated = $request->validate($rule);

        $data = new Pregnancy($validated);

        if($data->estimate_date_of_delivery == null) {
            // $lastPeriod = $request->first_day_of_last_period;
            // $data->estimate_date_of_delivery = //please add 40 weeks after first day of last period here
            $lastPeriod = $request->first_day_of_last_period;
            $date = new DateTime($lastPeriod);
            $date->modify('+40 weeks');
            $data->estimate_date_of_delivery = $date->format('Y-m-d');
        }

        $data->save();

        return [
            'success' => true,
            'message' => "Data saved!",
            'data' => $data
        ];
    }

    public function show(Request $request, $mother_id) {
        // find mother
        $mother = Mother::findOrFail($mother_id);

        return [
            'success' => true,
            'data' => $mother->pregnancy
        ];

    }
    
    public function showList(Request $request, $mother_id) {
        // find mother
        $mother = Mother::findOrFail($mother_id);

        return [
            'success' => true,
            'data' => $mother->pregnancies
        ];

    }

    public function getWeek() {
        // TODO get week of pregnancy
        $pregnancy = Pregnancy::where('mother_id', 1)->first();
        return $pregnancy;
    }
}
