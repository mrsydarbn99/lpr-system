<?php

namespace App\Http\Controllers;

use App\Models\NonResident;
use App\Models\Resident;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Count the number of residents with the status 'entry'
        $resident = Resident::count();
        $entryResidentCount = Resident::where('status', 'in')->count();
        $outResidentCount = Resident::where('status', 'out')->count();

        $nonResident = NonResident::count();
        $entryNonResidentCount = NonResident::where('status', 'in')->count();
        $outNonResidentCount = NonResident::where('status', 'out')->count();

        // Redirect to the dashboard view with the entry count
        return view('dashboard',[  
                                    'resident' => $resident,
                                    'nonResident' => $nonResident,
                                    'entryResidentCount' => $entryResidentCount, 
                                    'entryNonResidentCount' => $entryNonResidentCount,
                                    'outResidentCount' => $outResidentCount,
                                    'outNonResidentCount' => $outNonResidentCount
                                ]);
    }

}
