<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ChildDevelopmentHistory;
use App\Models\Mother;
use App\Models\PregnancyHistory;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    //
    public function get(Request $request, $guid) {
        $data = $this->getByGuid($guid);

        if($data) {
            $type = $data->type;
            if($type == 'mother') {
                $pregnancy = $data->pregnancy->latest_checkup ?? $data->pregnancy;
            }

            if($type == 'child') {
                $lates_checkup = $data->latest_checkup;
            }
        }

        return [
            'success' => true,
            'type' => is_null($data) ? null:$data->type,
            'data' => $data
        ];
    }

    public function getByGuid($guid) {
        $mother = Mother::where('guid', $guid)->first();

        if($mother) {
            $mother->type = 'mother';
            return $mother;
        }

        $child = Child::where('guid', $guid)->first();
        if($child) {
            $child->type = 'child';
        }

        return $child;
    }

    public function store(Request $request) {
        // 
        $request->validate([
            'type' => "required"
        ]);

        $type = $request->type;

        $res = [
            'success' => false,
            'message' => 'Data Saved Successfully'
        ];

        if($type == 'mother') {
            $res['data'] = $this->storeMother($request);
        }

        if($type == 'child') {
            $res['data'] = $this->storeChild($request);
        }

        return $res;
        
    }

    public function storeMother(Request $request) {
        $validated = $request->validate([
            'pregnancy_id' => 'required|integer',
            'complaint' => 'nullable',
            'blood_pressure' => "nullable|max:255",
            'weight' => "nullable|integer",
            'gestational_age' => "nullable|integer",
            'fundal_height' => "nullable|integer",
            'fetus_position' => "nullable|max:100",
            'swollen_foot' => "nullable",
            'lab_result' => "nullable",
        ]);

        $data = new PregnancyHistory($validated);

        $data->save();

        return $data;
    }
    
    public function storeChild( Request $request) {
        $validated = $request->validate([
            'child_id' => 'required|integer',
            'complaint' => 'nullable|string',
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'head_circumference' => 'nullable|numeric',
            'action' => 'nullable|string',
            'advice_given' => 'nullable|string',
        ]);

        $data = new ChildDevelopmentHistory($validated);

        $data->save();

        return $data;
    }
}
