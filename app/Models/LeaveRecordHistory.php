<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRecordHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'leave_id',
        'date',
        'start_time',
        'end_time',
        "capacity_hours",
        "leave_hours"

    ];
    public function getDurationAttribute()
    {
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);

        // Calculate the difference in hours
        return $startTime->diffInHours($endTime);
    }
    public function leave(){
        return $this->belongsTo(LeaveHistory::class,'leave_id', 'id');
    }
    
    // public function getCreatedAtAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }
    // public function getUpdatedAtAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }


    // public function getDateAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }




}
