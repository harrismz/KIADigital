<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pregnancy_history;
use App\Models\PregnancyHistory;
use Illuminate\Support\Facades\Auth;

class PregnancyHistoryController extends Controller
{
    // Method untuk menampilkan semua data pregnancy_history untuk user yang sedang login
    public function index(Request $request)
    {
        // $user = Auth::user(); // Mendapatkan user yang sedang login
        $history = PregnancyHistory::where(
            function($q) use ($request){

            }
        )
        ->with('pregnancy.mother')
        ->with('medicalStaff')
        // how to get with mother ??? pregnancy_history belongsTo Pregnancy, PRegnancy belongsTo Mother;
        ->paginate(); // Mengambil semua catatan kehamilan dari user tersebut

        return $history;
    }
    public function showLast(Request $request)
    {
        // TODO : get mother_id from user login
        $pregnancy = PregnancyHistory::where(
            function ($q) use ($request) {
                // $q->where('id', $request->mother_id);
            }
        )
        ->with('pregnancy.mother')
        ->latest()
        ->first();

        return $pregnancy;
    }

    // Method untuk menampilkan data pregnancy_history berdasarkan ID
    public function show($id,Request $request)
    {

        $data = PregnancyHistory::with(['pregnancy:id,mother_id', 'pregnancy.mother:id,name'])->findOrFail($id); // Mengambil catatan kehamilan berdasarkan ID untuk user yang sedang login

        return [
            'success'=> true,
            'data' => $data
        ];
    }
    public function searching(Request $request)
    {
        $data = PregnancyHistory::with(['pregnancy:id,mother_id', 'pregnancy.mother:id,name']);
        if($request){
            $data->where('complaint','like','%'.$request->search.'%');
            $data->orWhereHas('medicalStaff', function($query) use ($request){
                $query->where('staff_name','like','%'.$request->search.'%');
            });
        }
        $data = $data->get(); // Mengambil catatan kehamilan berdasarkan ID untuk user yang sedang login

        return [
            'success'=> true,
            'data' => $data
        ];
    }
}
