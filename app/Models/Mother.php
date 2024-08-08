<?php

namespace App\Models;

use App\Http\Traits\IdableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mother extends Model
{
    use HasFactory, IdableTrait;
    
    protected $table = "mother";

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pregnancies() {
        return $this->hasMany(Pregnancy::class);
    }

    public function children(){
        return $this->hasMany(Child::class);
    }

    public function pregnancy() {
        return $this->hasOne(Pregnancy::class)->latestOfMany();
    }

    public function pregnancyHistories()
    {
        return $this->hasManyThrough(PregnancyHistory::class, Pregnancy::class);
    }

    public function latest_checkup(){
        return $this->pregnancy()->latest_checkup();
    }

    public function checkups(){
        // return $this->hasMany(PregnancyHistory::class);
        $pregnancy = $this->pregnancy();

        $history = $pregnancy->checkups();

        return $history;
    }
}
