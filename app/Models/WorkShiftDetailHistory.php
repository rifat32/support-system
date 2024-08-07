<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkShiftDetailHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'work_shift_id',
        'day',
        "start_at",
        'end_at',
        'is_weekend',
    ];
    // public function getCreatedAtAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }
    // public function getUpdatedAtAttribute($value)
    // {
    //     return (new Carbon($value))->format('d-m-Y');
    // }

    public function work_shift(){
        return $this->belongsTo(WorkShiftHistory::class,'work_shift_id', 'id');
    }


}
