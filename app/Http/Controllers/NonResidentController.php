<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\View\View;
use App\Models\NonResident;
use Illuminate\Http\Request;
use App\Rules\UniquePlateNumber;
use Illuminate\Support\Facades\Auth;

class NonResidentController extends Controller
{
    protected $non_resident;

    public function __construct()
    {
        $this->non_resident = new NonResident();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $d['title'] = 'Non Resident List';
        $d['model'] = NonResident::paginate(10);
        return view('nonResidents.nonResidentList',$d);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $d['title']='Non Resident Form';
        $d['model']=new NonResident();
        return view('nonResidents.createNonResident', $d);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'name.required' => 'Please enter your name',
            'phone_num.required' => 'Please enter your phone number',
            'plate_num.required' => 'Please enter your plate number',
            'days.required' => 'Please enter how many days'
        ];

        $validate = $request->validate([
            'name' => 'required',
            'phone_num' => 'required',
            'plate_num' => ['required', new UniquePlateNumber],
            'days' => 'required|integer|min:1'
        ], $message);

        // Find the existing plate number entry if it exists
        $existingNonResident = NonResident::where('plate_num', $request->plate_num)->first();

        if ($existingNonResident) {
            $daysPassed = Carbon::parse($existingNonResident->created_at)->diffInDays(Carbon::now());
            // dd($daysPassed,$request->days);
            // If the existing entry is older than 24 hours, delete it
            if ($daysPassed >= $request->days) {
                $existingNonResident->delete();
            } else {
                return redirect()->back()->withErrors(['plate_num' => 'The plate number has already been registered.']);
            }
        }

        NonResident::create($validate);

        if (Auth::user()->is_admin ?? false) {
            return redirect()->route('non-resident-list')->with('success', 'Non-resident registered successfully.');
        } else {
            return redirect()->route('register')->with('success', 'Non-resident registered successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $d['title']='Non-Resident Form';
        $d['model']=NonResident::find($id);
        return view('nonResidents.editNonResident',$d);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $message=[
            'name.required'=>'Please enter your name',
            'phone_num.required'=>'Please enter your phone number',
            'plate_num.required'=>'Please enter your plate number',

        ];


        $validate=$request->validate([
            'name' => 'required',
            'phone_num' => 'required',
            'plate_num' => ['required', new UniquePlateNumber],

        ],$message);

        $data=NonResident::find($id);
        $data->update($validate);

        return redirect()->route('non-resident-list')->with('success', 'Non-resident updated successfully.');
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration(): View
    {
        return view('nonResidents.registration');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=NonResident::destroy($id);
        return redirect()->route('non-resident-list')->with('success', 'Non-resident deleted successfully.');
    }
}
