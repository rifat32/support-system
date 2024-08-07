<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRecordArrear extends Model
{
    use HasFactory;
    protected $fillable = [
        'leave_record_id',
        "status",
    ];

    public function leave_record()
    {
        return $this->belongsTo(LeaveRecord::class, "leave_record_id" ,'id');
    }




    // public function getCreatedAtAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }
    // public function getUpdatedAtAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }
}
