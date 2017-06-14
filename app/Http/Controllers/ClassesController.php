<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

class ClassesController extends Controller
{

    private $list = ['name','created_at'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,School $school)
    {
        $data = $school->classes()->select($this->list);
        if( $request->exists('datatables') )
        {
            return $this->response
                ->dataTables( $data->get() )
                ->respond();
        }

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
    public function store(Request $request,School $school)
    {
        $is_valid = $this->validate($request->all(),[
            'name'             => 'required|max:255',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'             => $request->name,
        ];
        $class = $school->classes()->create($attr);

        return $this->response->created($class)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function show(School $school,$id)
    {
        $data = $school->classes()->findOrFail($id);

        return $this->response->ok($data)->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $class)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,School $school,$id)
    {
        $is_valid = $this->validate($request->all(),[
            'name'             => 'required|max:255',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $class = $school->classes()->findOrFail($id);
        $class->name        = $request->name;

        $class->save();

        return $this->response->ok($class)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Class  $class
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school ,$id)
    {
        $class = $school->classes()->findOrFail($id);

        if($class->delete())
        {

            return $this->response->ok(['Deleted'])->respond();
        }
        else
        {
            return $this->response->notFound()->respond();
        }
    }
}
