<?php

namespace App\Http\Controllers;

use App\Models\Mother;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function test(Request $request) {

        $c = new PregnancyController;
        
        $req = new Request([
            'mother_id' => 1
        ]);

        return $c->getPrevPregNumber($req);

        return Mother::find(1);

        // $mother = new Mother([
        //     'name' =>"D",
        //     'nik' => 1231231231,
        //     'no_jkn' => 1124123123,
        //     'date_of_birth' => '1994-07-30',
        //     'birth_place' => "karawang",
        //     'kecamatan_id' => 2,
        //     'user_id' => 2
        // ]);

        // $mother->save();
        // return $mother;
    }
}
