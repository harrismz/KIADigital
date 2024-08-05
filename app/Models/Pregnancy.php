<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mother;

class Pregnancy extends Model
{
    use HasFactory;
    
    protected $table = "pregnancy";

    protected $guarded = ['id'];

    public function mother(){
        return $this->belongsTo(Mother::class);
    }

    public function checkups(){
        return $this->hasMany(PregnancyHistory::class);
    }

    public function latest_checkup(){
        return $this->hasOne(PregnancyHistory::class)
            ->latestOfMany();
    }
}
