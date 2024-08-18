<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\ChildDevelopmentHistory;
use App\Models\MedicalStaff;
use App\Models\Mother;
use App\Models\PregnancyHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckupController extends Controller
{
    //
    public function index(Request $request)
    {
        // disini, harus menggabungkan data checkup ibu di table pregnancy_history
        // dengan data anak, child_developent history
        // baru di kirim

        // todo, json key harus punya type, sisanya key nya disamain.

        // yang perlu, nama patient

        // complain & action

        // created at

        // link ke detail
        $staffId = $request->query('id');
        $pregnancy = PregnancyHistory::select([
            'id','complaint', 'action', 'created_at', 'pregnancy_id', DB::raw( "'mom' as type")
        ])->where(
            function ($q) use ($staffId) {
                $q->where('staff_id', $staffId);
            }
        )
        ->with(['pregnancy:id,mother_id','pregnancy.mother:id,name'])
        ->orderBy('id', 'desc')
        // how to get with mother ??? pregnancy_history belongsTo Pregnancy, PRegnancy belongsTo Mother;
        ->get(); // Mengambil semua catatan kehamilan dari user tersebut

        $child = ChildDevelopmentHistory::select([
            'id', 'complaint', 'action', 'created_at', 'id', 'child_id', DB::raw('"child" as type')
        ])->where(
            function ($q) use ($staffId) {
                $q->where('staff_id', $staffId);
            }
        )
        ->with('child:id,child_name')->get();

        // $merge = $pregnancy->merge($child); //how to merge the laravel Collection ???
         // Merge the collections
        $merged = $pregnancy->concat($child);

        // Sort the merged collection by created_at
        $sorted = $merged->sortByDesc('created_at');

        // Convert to array (optional, based on your API response format)
        $sortedArray = $sorted->values()->all();

        return [
            'success' => true,

            'data' => $sortedArray
        ];

    }
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
            'usg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'hospital_id' => "nullable|integer", // find hospital id from staff_id
            'staff_id' => "nullable|integer", //
            'next_control' => "nullable|date",
            'week' => "nullable",
            'advice_given' => "nullable",
            'action' => "nullable",
        ]);

        if ($request->hasFile('usg_image')) {
            $file = $request->file('usg_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $filename, 'public');
            $validated['usg_image'] = $filePath;

        }

        $data = new PregnancyHistory($validated);

        // get hospital id
        $staff = MedicalStaff::where('user_id', $validated['staff_id'])->first();
        if($staff) {
            $data->staff_id = $staff->id;
            $data->hospital_id = $staff->hospital_id;
        }

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
            'staff_id' => 'nullable|integer',
        ]);

        $data = new ChildDevelopmentHistory($validated);

        $data->save();

        return $data;
    }
}
