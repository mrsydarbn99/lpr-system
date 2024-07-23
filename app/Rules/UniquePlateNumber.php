<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Resident;
use App\Models\NonResident;
use Carbon\Carbon;

class UniquePlateNumber implements Rule
{
    public function passes($attribute, $value)
    {
        // Check in Residents table for uniqueness
        $existsInResidents = Resident::where('plate_num', $value)->exists();

        // Check in NonResidents table for both uniqueness and time constraint
        $recentInNonResidents = NonResident::where('plate_num', $value)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->exists();

        return !$existsInResidents && !$recentInNonResidents;
    }

    public function message()
    {
        return 'The plate number has already been registered within the last 24 hours.';
    }
}
