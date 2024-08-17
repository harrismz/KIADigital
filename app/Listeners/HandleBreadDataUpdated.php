<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\MedicalStaff;

class HandleBreadDataUpdated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
        $this->updateStaff($event->dataType, $event->data);
    }

    public function updateStaff($dataType, $data) {
        // add data
        if($dataType['slug'] == 'users') {
            // insert into staff
            $request = request();

            $staff = MedicalStaff::where('user_id', $data->id)->first();
            $staff->staff_name = $data->name;
            $staff->hospital_id = $request->hospital_id;
            $staff->role = $request->role_tenaga_medis;
            $staff->save();

        }
    }
}
