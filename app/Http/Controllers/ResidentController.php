<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use Illuminate\Http\Request;
use App\Rules\UniquePlateNumber;

class ResidentController extends Controller
{

    protected $resident;

    public function __construct()
    {
        $this->resident = new Resident();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $d['title'] = 'Resident List';
        $d['model'] = Resident::paginate(10);
        return view('residents.residentList',$d);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $d['title']='Resident Form';
        $d['model']=new Resident();
        return view('residents.createResident', $d);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        Resident::create($validate);

        return redirect()->route('resident-list')->with('success', 'Resident registered successfully.');
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
        $d['title']='Resident Form';
        $d['model']=Resident::find($id);
        return view('residents.editResident',$d);
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

        $data=Resident::find($id);
        $data->update($validate);

        return redirect()->route('resident-list')->with('success', 'Resident updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=Resident::destroy($id);
        return redirect()->route('resident-list')->with('success', 'Resident deleted successfully.');
    }
}
