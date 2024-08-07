<?php

namespace App\Rules;

use App\Models\JobType;
use Illuminate\Contracts\Validation\Rule;

class ValidateJobTypeName implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */


     protected $id;
    protected $errMessage;

    public function __construct($id)
    {
        $this->id = $id;
        $this->errMessage = "";

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $created_by  = NULL;
        if(auth()->user()->business) {
            $created_by = auth()->user()->business->created_by;
        }

        $data = JobType::where("job_types.name",$value)
        ->when(!empty($this->id),function($query) {
            $query->whereNotIn("id",[$this->id]);
        })

        ->when(empty(auth()->user()->business_id), function ($query)  {
            $query->where(function($query) {
                if (auth()->user()->hasRole('superadmin')) {
                    return $query->where('job_types.business_id', NULL)
                        ->where('job_types.is_default', 1);
                        // ->where('job_types.is_active', 1);

                } else {
                    return $query->where('job_types.business_id', NULL)
                        ->where('job_types.is_default', 1)
                        ->where('job_types.is_active', 1)
                        // ->whereDoesntHave("disabled", function($q) {
                        //     $q->whereIn("disabled_job_types.created_by", [auth()->user()->id]);
                        // })

                        ->orWhere(function ($query)   {
                            $query->where('job_types.business_id', NULL)
                                ->where('job_types.is_default', 0)
                                ->where('job_types.created_by', auth()->user()->id)
                                // ->where('job_types.is_active', 1)
                                ;


                        });
                }
            });

        })
            ->when(!empty(auth()->user()->business_id), function ($query) use ($created_by) {


                $query->where(function($query) use($created_by) {
                    $query->where('job_types.business_id', NULL)
                    ->where('job_types.is_default', 1)
                    ->where('job_types.is_active', 1)
                    ->whereDoesntHave("disabled", function($q) use($created_by) {
                        $q->whereIn("disabled_job_types.created_by", [$created_by]);
                    })
                    // ->whereDoesntHave("disabled", function($q)  {
                    //     $q->whereIn("disabled_job_types.business_id",[auth()->user()->business_id]);
                    // })

                    ->orWhere(function ($query) use( $created_by){
                        $query->where('job_types.business_id', NULL)
                            ->where('job_types.is_default', 0)
                            ->where('job_types.created_by', $created_by)
                            ->where('job_types.is_active', 1);
                            // ->whereDoesntHave("disabled", function($q) {
                            //     $q->whereIn("disabled_job_types.business_id",[auth()->user()->business_id]);
                            // });
                    })
                    ->orWhere(function ($query)   {
                        $query->where('job_types.business_id', auth()->user()->business_id)
                            ->where('job_types.is_default', 0);
                            // ->where('job_types.is_active', 1);


                    });
                });

            })
        ->first();

        if(!empty($data)){


            if ($data->is_active) {
                $this->errMessage = "A job type with the same name already exists.";
            } else {
                $this->errMessage = "A job type with the same name exists but is deactivated. Please activate it to use.";
            }


            return 0;

        }
     return 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errMessage;
    }
}
