<?php

namespace App\Http\Controllers;

use App\Models\WeeklyChildMonitoringPeriod;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    //
    public function show(Request $request, $id) {
        // return $id;

        $period = WeeklyChildMonitoringPeriod::findOrFail($id);

        return [
            'success' => true,
            'data' => $period
        ];

    }
}
