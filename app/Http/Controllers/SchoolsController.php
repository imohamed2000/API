<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\School;
use App\File;


class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::latest()->get();

        return $this->response->ok($schools)->respond();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $is_valid = $this->validate(request()->all(),[
                'name'              => 'required|max:255',
                'code'              => 'required|max:255',
                'contact_no'        => 'required|max:42',
                'email'             => 'required|email',
                'alternate_email'   => 'required|email|different:email',
                'address'           => 'required|max:255',
                'city'              => 'required|max:255',
                'zip'               => 'required|max:255',
                'logo'              => 'required|image'
            ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $path = 'uploads/schools/logo'; // upload path
        $extension = $request->file('logo')->getClientOriginalExtension(); // getting image extension
        $filename = 'logo'.time().rand(0000000,9999999999).'-'.rand(0000000000000,99999999999).time().'.'.$extension; // renaming image
        $type = $request->file('logo')->getMimeType();
        $size = $request->file('logo')->getClientSize();
        $original = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move($path, $filename); // uploading file

        $saveFile = new File();
        $saveFile->filename = $filename;
        $saveFile->original_name = $original;
        $saveFile->type = $type;
        $saveFile->size = $size;
        $saveFile->save();

        $school = new School();
        $school->name = $request->name;
        $school->code = $request->code;
        $school->contact_no = $request->contact_no;
        $school->email = $request->email;
        $school->alternate_email = $request->alternate_email;
        $school->address = $request->address;
        $school->city = $request->city;
        $school->zip = $request->zip;
        $school->logo_id = $saveFile->id;
        $school->save();


        return $this->response->created($school)->respond();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $school = School::where('id',$id)->with('logo')->first();
        if($school)
        {
            return $this->responses->ok($school)->respond();
        }
        else
        {
            return $this->responses->notFound()->respond();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school)
    {

        $validate = $this->validate(request()->all(),[
            'name'              => 'required|max:255',
            'code'              => 'required|max:255',
            'contact_no'        => 'required|max:42',
            'email'             => 'required|email',
            'alternate_email'   => 'required|email|different:email',
            'address'           => 'required|max:255',
            'city'              => 'required|max:255',
            'zip'               => 'required|max:255',
            'logo'              => 'image'
        ]);

        if($validate)
        {
            return $this->responses->badRequest($validate->errors()->all())->respond();
        }
        $logo_id = $school->logo_id;
        if($request->hasFile('logo'))
        {
            $path = 'uploads/schools/logo';
            $extension = $request->file('logo')->getClientOriginalExtension(); // getting image extension
            $filename = 'logo'.time().rand(0000000,9999999999).'-'.rand(0000000000000,99999999999).time().'.'.$extension; // renaming image
            $type = $request->file('logo')->getMimeType();
            $size = $request->file('logo')->getClientSize();
            $original = $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move($path, $filename); // uploading file

            $saveFile = new File();
            $saveFile->filename = $filename;
            $saveFile->original_name = $original;
            $saveFile->type = $type;
            $saveFile->size = $size;
            $saveFile->save();

            // Find old logo
            $oldLogo = File::find($logo_id);
            // Delete from server
            Storage::delete($path.'/'.$oldLogo->filename);
            // Delete From database
            $oldLogo->forceDelete();

            $logo_id = $saveFile->id;
        }
        $school->update([
            'name'              => $request->name,
            'code'              => $request->code,
            'contact_no'        => $request->contact_no,
            'email'             => $request->email,
            'alternate_email'   => $request->alternate_email,
            'address'           => $request->address,
            'city'              => $request->city,
            'zip'               => $request->zip,
            'logo_id'           => $logo_id
        ]);

        return $this->responses->ok($school)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::where('id',$id)->first();
        if($school)
        {
            $school->delete();

            return $this->responses->ok(['Deleted'])->respond();
        }
        else
        {
            return $this->responses->notFound()->respond();
        }

    }
}
