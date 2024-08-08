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
        // how to get with mother ??? pregnancy_history belongsTo Pregnancy, PRegnancy belongsTo Mother;
        ->paginate(); // Mengambil semua catatan kehamilan dari user tersebut

        return $history;
    }

    // Method untuk menampilkan data pregnancy_history berdasarkan ID
    public function show($id)
    {
        $data = PregnancyHistory::with(['pregnancy:id,mother_id', 'pregnancy.mother:id,name'])->findOrFail($id); // Mengambil catatan kehamilan berdasarkan ID untuk user yang sedang login

        return [
            'success'=> true,
            'data' => $data
        ];
    }
}
