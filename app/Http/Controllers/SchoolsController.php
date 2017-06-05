<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\School;
use App\File;
use App\Helpers\Upload;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $data = School::latest();
        // datatables request
        if( $request->exists('datatables') )
        {
            return $this->response
                        ->dataTables( $data->get() )
                        ->respond();
        }

        //pagination request
        if( $request->has('per_page') )
        {
            $data = $data->paginate( $request->input('per_page') );
        }
        else
        {
            $data = $data->get();
        }

        return $this->response->ok($data)->respond();
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
        $upload = new Upload('logo',$path,'add');

        $school = new School();
        $school->name = $request->name;
        $school->code = $request->code;
        $school->contact_no = $request->contact_no;
        $school->email = $request->email;
        $school->alternate_email = $request->alternate_email;
        $school->address = $request->address;
        $school->city = $request->city;
        $school->zip = $request->zip;
        $school->logo_id = $upload->savedFile->id;
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
            $path = 'uploads/schools/logo'; // upload path
            $upload = new Upload('logo',$path,'edit',$school->logo_id);
            $logo_id = $upload->savedFile->id;
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
