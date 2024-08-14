<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyMonitoringAnswer extends Model
{
    use HasFactory;
    protected $table = "weekly_monitoring_answer";
    protected $fillable = [
        'pregnancy_id',
        'week_number',
        'question',
        'answer',
        'created_at',
        'updated_at',
        'weekly_monitoring_question_id'
    ];
    protected $guarded = ['id'];
}
