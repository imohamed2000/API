<?php

namespace App\Http\Controllers;

use App\Beak\Upload;
use App\Events\SchoolCreated;
use App\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SchoolsController extends Controller
{

    private $list = ['id','name','slug','email','city'];
    private $logo = 3;

    public function __construct(Request $request){
        parent::__construct();
        //$this->middleware('jwt_auth');
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
        if($request->has('slug'))
            $request->merge([
                    'slug'  => str_slug( $request->input('slug') )
                ]);

        $is_valid = $this->validate($request->all(),[
                'name'              => 'required|max:255',
                'slug'              => 'required|max:20|unique:schools',
                'email'             => 'email|required|unique:schools',
                'address'           => 'max:255',
                'city'              => 'max:255',
                'zip'               => 'max:255',
                'logo'              => 'image|nullable'
            ]);

        if(!$is_valid)
        {   
            return $this->response->badRequest($this->errors)->respond();
        }

        if($request->hasFile('logo'))
        {   
            $logo= new Upload;
            $logo->put($request->file('logo'), 'schools/logo');
            $this->logo = $logo->getFileData()->id;
        }

        $school = new School();
        $school->name = $request->name;
        $school->slug = str_slug($request->slug);
        $school->email = $request->email;
        $school->address = $request->address;
        $school->city = $request->city;
        $school->zip = $request->zip;
        $school->logo_id = $this->logo;
        $school->save();

        // Trigger School Created Event
        $event_data = event( new SchoolCreated( $school ) );
        $school->roles = $event_data[0];

        //Return response
        return $this->response->created($school)->respond();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {   
        //TODO get school by id
        $school = School::with('roles')->where('slug', $slug)->first();
        if(!$school){
            return $this->response->notFound()->respond();
        }
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
        // TODO Update school by slug
        if($request->has('slug'))
            $request->merge([
                    'slug'  => str_slug( $request->input('slug') )
                ]);
        $validate = $this->validate($request->all(),[
            'name'              => 'required|max:255',
            'slug' => [
                'required',
                Rule::unique('schools')->ignore($school->id),
                'max:20'
            ],
            'email'             => 'email',
            'address'           => 'max:255',
            'city'              => 'max:255',
            'zip'               => 'max:255',
            'logo'              => 'image|nullable'
        ]);

        if(!$validate)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        if($request->hasFile('logo'))
        {   
            $logo = new Upload;
            if($school->logo_id == $this->logo){
                // upload new logo
                $logo->put($request->file('logo'), 'schools/logo');
            }else{
                // override old logo
                $logo->replace( $school->logo_id, $request->file('logo') );
            }
            $school->logo_id = $logo->getFileData()->id;
        }

        // Clearing Logo
        if($request->has('clear_logo')){
            $school->logo_id = $this->logo;
        }

        $school->update([
            'name'              => $request->name,
            'slug'              => str_slug($request->slug),
            'email'             => $request->email,
            'address'           => $request->address,
            'city'              => $request->city,
            'zip'               => $request->zip,
            'logo_id'           => $school->logo_id
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
        // TODO destroy school by slug
        $school = School::findOrFail($id);
        $school->delete();
        return $this->response->ok(['Deleted'])->respond();
    }

    /**
     * Display Trashed
     *
     * @return \App\Beak\Response
     */
    public function trashed()
    {
        $trashed = School::onlyTrashed()->get();

        return $this->response->ok($trashed)->respond();
    }

    /**
     * Restore  specific trashed
     * @param  \App\School  $school
     * @return \App\Beak\Response
     */
    public function restore(School $school)
    {
        if ($school->trashed())
        {
            $school->restore();
            return $this->response->ok($school)->respond();
        }

        return $this->response->badRequest(['Error request'])->respond();
    }


    public function getCurrent(School $school)
    {
        $year = $school->years()->where('current',1)->first();

        return $this->response->ok($year)->respond();
    }


}
