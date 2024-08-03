<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pregnancy_history;
use Illuminate\Support\Facades\Auth;

class PregnancyHistoryController extends Controller
{
    // Method untuk menampilkan semua data pregnancy_history untuk user yang sedang login
    public function index()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $pregnancy_history = pregnancy_history::where('user_id', $user->id)->get(); // Mengambil semua catatan kehamilan dari user tersebut

        return response()->json([
            'pregnancy_history' => $pregnancy_history
        ], 200); // Mengembalikan data dalam bentuk JSON
    }

    // Method untuk menampilkan data pregnancy_history berdasarkan ID
    public function show($id)
    {
        $user = Auth::user();
        $pregnancy_history = pregnancy_history::where('user_id', $user->id)->findOrFail($id); // Mengambil catatan kehamilan berdasarkan ID untuk user yang sedang login

        return response()->json([
            'pregnancy_history' => $pregnancy_history
        ], 200); // Mengembalikan data dalam bentuk JSON
    }
}
