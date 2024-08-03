<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Mother;
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
}
