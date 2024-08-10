<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\IdableTrait;

class Child extends Model
{
    use HasFactory, IdableTrait;

    protected $table = "child";

    public function latest_checkup(){
        return $this->hasOne(ChildDevelopmentHistory::class)->latestOfMany();
    }
    public function father(){
        return $this->belongsTo(Mother::class);
    }
}
