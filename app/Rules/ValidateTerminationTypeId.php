<?php

namespace App\Rules;

use App\Models\TerminationType;
use Illuminate\Contracts\Validation\Rule;

class ValidateTerminationTypeId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        $exists = TerminationType::where("termination_types.id",$value)
        ->when(empty(auth()->user()->business_id), function ($query)  {

            $query->where(function($query) {
                if (auth()->user()->hasRole('superadmin')) {
                    return $query->where('termination_types.business_id', NULL)
                        ->where('termination_types.is_default', 1)
                        ->where('termination_types.is_active', 1);

                } else {
                    return $query->where('termination_types.business_id', NULL)
                        ->where('termination_types.is_default', 1)
                        ->where('termination_types.is_active', 1)
                        ->whereDoesntHave("disabled", function($q) {
                            $q->whereIn("disabled_termination_types.created_by", [auth()->user()->id]);
                        })

                        ->orWhere(function ($query)  {
                            $query->where('termination_types.business_id', NULL)
                                ->where('termination_types.is_default', 0)
                                ->where('termination_types.created_by', auth()->user()->id)
                                ->where('termination_types.is_active', 1);


                        });
                }
            });

        })
            ->when(!empty(auth()->user()->business_id), function ($query) use ($created_by) {


                $query->where(function($query) use($created_by) {
                    $query->where('termination_types.business_id', NULL)
                    ->where('termination_types.is_default', 1)
                    ->where('termination_types.is_active', 1)
                    ->whereDoesntHave("disabled", function($q) use($created_by) {
                        $q->whereIn("disabled_termination_types.created_by", [$created_by]);
                    })
                    ->whereDoesntHave("disabled", function($q)  {
                        $q->whereIn("disabled_termination_types.business_id",[auth()->user()->business_id]);
                    })

                    ->orWhere(function ($query) use( $created_by){
                        $query->where('termination_types.business_id', NULL)
                            ->where('termination_types.is_default', 0)
                            ->where('termination_types.created_by', $created_by)
                            ->where('termination_types.is_active', 1)
                            ->whereDoesntHave("disabled", function($q) {
                                $q->whereIn("disabled_termination_types.business_id",[auth()->user()->business_id]);
                            });
                    })
                    ->orWhere(function ($query)   {
                        $query->where('termination_types.business_id', auth()->user()->business_id)
                            ->where('termination_types.is_default', 0)
                            ->where('termination_types.is_active', 1);

                    });
                });

            })
        ->exists();
        return $exists;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is invalid.';
    }
}
