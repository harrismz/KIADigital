<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PregnancyHistory extends Model
{
    use HasFactory;
    
    protected $table = "pregnancy_history";

    protected $guarded = ['id'];

    public function pregnancy(){
        return $this->belongsTo(Pregnancy::class);
    }
}
