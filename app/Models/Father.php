<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Father extends Model
{
    use HasFactory;
    protected $table = "father";
    protected $guarded = ['id'];

    public function mother() : belongsTo
    {
        return $this->belongsTo(Mother::class, 'mother_id');
    }

    public function kecamatan()
    {
        return $this->hasOne(Kecamatan::class, 'id', 'kecamatan_id');
    }

    public function religion()
    {
        return $this->hasOne(Religion::class, 'id','religion_id');
    }

    public function education()
    {
        return $this->hasOne(Education::class, 'id','education_id');
    }

    public function bloodType()
    {
        return $this->hasOne(BloodType::class, 'id','blood_type_id');
    }

    public function job()
    {
        return $this->hasOne(Job::class, 'id','job_id');
    }

}
