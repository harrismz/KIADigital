<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelurahan;
use App\Models\Kecamatan;
use App\Models\Province;

class LocationController extends Controller
{
    public function getKelurahan()
    {   

        $kelurahan = Kelurahan::limit(100)->get();

        // Mengecek apakah user ditemukan
        if ($kelurahan) {
            // Mengembalikan response jika kelurahan ditemukan
            return response()->json($kelurahan, 200);
        } else {
            // Mengembalikan response jika kelurahan tidak ditemukan
            return response()->json(['message' => 'kelurahan not found.'], 404);
        }
    }

    public function getAllKecamatan() {
        $kecamatan = Kecamatan::limit(1000)->get();

        return response()->json($kecamatan, 200);
    }

    public function getKecamatan($id)
    {
        $kecamatan_id = Kelurahan::where('id',$id)->pluck('kecamatan_id');
        $kecamatan = Kecamatan::find($kecamatan_id);

        // Mengecek apakah user ditemukan
        if ($kecamatan) {
            // Mengembalikan response jika kecamatan ditemukan
            return response()->json($kecamatan, 200);
        } else {
            // Mengembalikan response jika kecamatan tidak ditemukan
            return response()->json(['message' => 'kecamatan not found.'], 404);
        }
    }
    public function getKabupaten($id)
    {
        $kabupaten_id = Kecamatan::where('id',$id)->pluck('kabupaten_id');
        $kabupaten = Kabupaten::find($kabupaten_id);

        // Mengecek apakah user ditemukan
        if ($kabupaten) {
            // Mengembalikan response jika kabupaten ditemukan
            return response()->json($kabupaten, 200);
        } else {
            // Mengembalikan response jika kabupaten tidak ditemukan
            return response()->json(['message' => 'kabupaten not found.'], 404);
        }
    }

    public function getProvince($id)
    {
        $provinsi_id = Kabupaten::where('id',$id)->pluck('provinsi_id');
        $province = Province::find($provinsi_id);

        // Mengecek apakah user ditemukan
        if ($province) {
            // Mengembalikan response jika province ditemukan
            return response()->json($province, 200);
        } else {
            // Mengembalikan response jika province tidak ditemukan
            return response()->json(['message' => 'province not found.'], 404);
        }
    }
}
