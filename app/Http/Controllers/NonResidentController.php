<?php

namespace App\Http\Controllers;

use App\Models\NonResident;
use Illuminate\Http\Request;

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
        $message=[
            'name.required'=>'Please enter your name',
            'phone_num.required'=>'Please enter your phone number',
            'plate_num.required'=>'Please enter your plate number',

        ];


        $validate=$request->validate([
            'name' => 'required',
            'phone_num' => 'required',
            'plate_num' => 'required',

        ],$message);

        NonResident::create($validate);

        return redirect()->route('non-resident-list');
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
            'plate_num' => 'required',

        ],$message);

        $data=NonResident::find($id);
        $data->update($validate);

        return redirect()->route('non-resident-list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data=NonResident::destroy($id);
        return redirect()->route('non-resident-list');
    }
}
