<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\DailyAssignment;

class UniqueAttemptDateRule implements Rule
{
    private $classroom_id;
    private $daily_assignment_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($classroom_id, $daily_assignment_id=null)
    {
        $this->classroom_id = $classroom_id;
        $this->daily_assignment_id = $daily_assignment_id;
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
        $is_assignment_duplicate = DailyAssignment::where('attempt_date',$value)
        ->where('classroom_id',$this->classroom_id)
        ->where('id','!=',$this->daily_assignment_id)
        ->exists();
        if($is_assignment_duplicate){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
