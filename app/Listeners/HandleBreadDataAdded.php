<?php

namespace App\Listeners;

use App\Models\MedicalStaff;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleBreadDataAdded
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
        // Call any other functions if needed
        $this->SaveToStaff($event->dataType, $event->data);
    }

    public function SaveToStaff($dataType, $data) {
        // add data
        if($dataType['slug'] == 'users') {
            // insert into staff
            $request = request();

            $staff = new MedicalStaff([
                'staff_name' => $data->name,
                'user_id' => $data->id,
                'hospital_id' => $request->hospital_id,
                'role' => $request->role_tenaga_medis
            ]);

            $staff->save();
        }
    }


}
