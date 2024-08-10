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
    public function father(){
        return $this->hasMany(Father::class);
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

    public function kecamatan(): belongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function religion(): belongsTo
    {
        return $this->belongsTo(Religion::class, 'religion_id');
    }

    public function education(): belongsTo
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function bloodType(): belongsTo
    {
        return $this->belongsTo(BloodType::class, 'blood_type_id');
    }
}
