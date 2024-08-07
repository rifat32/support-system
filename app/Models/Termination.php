<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'termination_type_id',
        'termination_reason_id',
        'date_of_termination',
        'joining_date',
        'final_paycheck_date',
        'final_paycheck_amount',
        'unused_vacation_compensation_amount',
        'unused_sick_leave_compensation_amount',
        'severance_pay_amount',
        'benefits_termination_date',
        'continuation_of_benefits_offered',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function terminationType()
    {
        return $this->belongsTo(TerminationType::class);
    }

    public function terminationReason()
    {
        return $this->belongsTo(TerminationReason::class);
    }
}
