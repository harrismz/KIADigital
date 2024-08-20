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
            'kek' => 'nullable',
            'contraception_id' => 'nullable|integer',
            // 'pregnancy_number' => 'nullable|integer',
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

        // pregnancy number based on how many prev pregnancy data on mother;
        $prevPregNumber = $this->getPrevPregNumber($request);
        $data->pregnancy_number = $prevPregNumber;

        $data->save();

        return [
            'success' => true,
            'message' => "Data saved!",
            'data' => $data
        ];
    }

    public function getPrevPregNumber(Request $request) {
        $validated = $request->validate([
            'mother_id' => 'required|integer'
        ]);

        $prevPregNumber = Pregnancy::where('mother_id', $request->mother_id)->count();

        return $prevPregNumber + 1; // +1 karena asumsinya
    }

    public function update(Request $request, $id ) {
        $rule = [
            // 'id' => 'nullable|integer',
            'mother_id' => 'required|integer',
            'first_day_of_last_period' => 'required|date',
            'estimate_date_of_delivery' => 'nullable|date',
            'upper_arm_circumference' => 'nullable|numeric',
            'kek' => 'nullable',
            'contraception_id' => 'nullable|integer',
            // 'pregnancy_number' => 'nullable|integer',
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

        $data = Pregnancy::findOrFail($id);

        foreach ($validated as $key => $value) {
            # code...
            $data->{$key} = $value;
        }

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
            'message' => "Data Updated!",
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

    public function showPregnancy(Request $request, $id) {
        // find mother
        $data = Pregnancy::find($id);

        return [
            'success' => true,
            'data' => $data
        ];

    }

    public function getWeek() {
        // TODO get week of pregnancy
        $pregnancy = Pregnancy::where('mother_id', 1)->first();
        return $pregnancy;
    }
    // public function getHplDate(Request $request, $id){
    //     // find hpl
    //     $data = Pregnancy::where('mother_id',$id)
    //             ->select('estimate_date_of_delivery')
    //             ->get();

    //     return [
    //         'success' => true,
    //         'data' => $data
    //     ];
    // }
}
