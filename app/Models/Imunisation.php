<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisation extends Model
{
    use HasFactory;
    
    protected $table = "imunisation";

    protected $guarded = ['id'];

    // 'child', 'hospital', 'staff', 'vaccine'
    public function child(){
        return $this->belongsTo(Child::class);
    }

    public function hospital(){
        return $this->belongsTo(Hospital::class);
    }

    public function staff(){
        return $this->belongsTo(MedicalStaff::class);
    }

    public function vaccine(){
        return $this->belongsTo(Vaccine::class);
    }
    
}
