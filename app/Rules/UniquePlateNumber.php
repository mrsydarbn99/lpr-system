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

        // Fetch the non-resident entry for the plate number
        $nonResident = NonResident::where('plate_num', $value)->first();

        if ($nonResident) {
            $days = $nonResident->days;

            // Check if the record is within the specified number of days
            $recentInNonResidents = NonResident::where('plate_num', $value)
                ->where('created_at', '>=', Carbon::now()->subDays($days))
                ->exists();
        }else
            $recentInNonResidents = true;
        
        // dd($existsInResidents);
        return !$existsInResidents && !$recentInNonResidents;
        
    }

    public function message()
    {
        return 'The plate number has already been registered..';
    }
}
