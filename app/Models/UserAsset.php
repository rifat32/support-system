<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAsset extends Model
{
    use HasFactory;
    protected $appends = ['can_delete'];
    protected $fillable = [
        'user_id',
        'name',
        'code',
        'serial_number',
        'type',
        "is_working",
        "status",
        'image',
        'date',
        'note',
        "business_id",
        'created_by',
    ];

    public function getCanDeleteAttribute($value) {
        $request = request();
        // You can now use $currentRequest as the request object

        if(!auth()->user()->hasRole("business_owner") && auth()->user()->id != $this->created_by) {
                return 0;
        }
        return 1;

        }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by','id');
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
