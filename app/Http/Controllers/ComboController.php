<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComboController extends Controller
{
    //
    public function get(Request $request, $modelname) {
        // how to get model from modelname ?;

        // example, modelname = 'kecamatan', i want \App\Models\Kecamatan
        $modelClass = "\App\Models\\". ucfirst( $modelname );

        if(!class_exists($modelClass)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'model not found'
            ], 404 );
        }

        $data = ($modelClass)::select(
            [
                'id as value',
                $modelClass::getComboKey() .' as key'
            ]
        )->limit(250)->get();

        return [
            'success' => true,
            'data' => $data
        ];

    }

    public function getById(Request $request, $modelname, $id) {

        $modelClass = "\App\Models\\". ucfirst( $modelname );

        if(!class_exists($modelClass)) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => 'model not found'
            ], 404 );
        }

        if($modelname == "bloodType")
        {
            $data = ($modelClass)::select(
                [
                    'id as value',
                    $modelClass::getComboKey() .' as key',
                    'reshus'
                ]
            )->find($id);

            return [
                'success' => true,
                'data' => $data
            ];
        }

        $data = ($modelClass)::select(
            [
                'id as value',
                $modelClass::getComboKey() .' as key'
            ]
        )->find($id);

        return [
            'success' => true,
            'data' => $data
        ];

    }
}
