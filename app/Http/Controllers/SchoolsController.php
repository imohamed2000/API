<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School;
use App\Beak\Upload;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SchoolsController extends Controller
{

    private $list = ['id','name','slug','email','city'];

    public function __construct(Request $request){
        parent::__construct();
        $this->middleware('jwt_auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = School::select($this->list)->latest();
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
                'slug'              => 'required|max:255|unique:schools,slug',
                'email'             => 'email',
                'address'           => 'max:255',
                'city'              => 'max:255',
                'zip'               => 'max:255',
                'logo'              => 'image'
            ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }
        $logo = 3;
        if($request->hasFile('logo'))
        {
            $upload = new Upload('logo','schoolLogo','add');
            $logo = $upload->savedFile->id;
        }

        $school = new School();
        $school->name = $request->name;
        $school->slug = str_slug($request->slug);
        $school->email = $request->email;
        $school->address = $request->address;
        $school->city = $request->city;
        $school->zip = $request->zip;
        $school->logo_id = $logo;
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
        $school = School::findOrFail($id);
        $school->logoURL = Storage::disk('schoolLogo')->url($school->logo()->first()->filename);
        return $this->response->ok($school)->respond();
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
            'slug' => [
                'required',
                Rule::unique('schools')->ignore($school->id),
                'max:255'
            ],
            'email'             => 'email',
            'address'           => 'max:255',
            'city'              => 'max:255',
            'zip'               => 'max:255',
            'logo'              => 'image'
        ]);

        if(!$validate)
        {
            return $this->response->badRequest($this->errors)->respond();
        }
        $logo_id = $school->logo_id;
        if($request->hasFile('logo'))
        {
            $upload = new Upload('logo','schoolLogo','edit',$school->logo_id);
            $logo_id = $upload->savedFile->id;
        }

        $school->update([
            'name'              => $request->name,
            'slug'              => str_slug($request->slug),
            'email'             => $request->email,
            'address'           => $request->address,
            'city'              => $request->city,
            'zip'               => $request->zip,
            'logo_id'           => $logo_id
        ]);

        return $this->response->ok($school)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $school->delete();
        return $this->response->ok(['Deleted'])->respond();

    }
}
