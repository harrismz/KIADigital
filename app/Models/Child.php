<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\IdableTrait;

class Child extends Model
{
    use HasFactory, IdableTrait;

    protected $table = "child";

    protected $guarded = ['id'];

    public function latest_checkup(){
        return $this->hasOne(ChildDevelopmentHistory::class)->latestOfMany();
    }

    public function bloodType()
    {
        return $this->hasOne(BloodType::class, 'id','blood_type_id');
    }

    public function mother()
    {
        return $this->belongsTo(Mother::class, 'mother_id','id');
    }

    public function father()
    {
        return $this->belongsTo(Father::class, 'father_id','id');
    }
}
