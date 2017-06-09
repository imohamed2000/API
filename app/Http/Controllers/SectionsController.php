<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;
use App\School;
use App\Classes;

class SectionsController extends Controller
{
    private $list = ['name','created_at'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,School $school,$class_id)
    {
        $data = $school->classes()->findOrFail($class_id);
        $data = $data->sections()->select($this->list);
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
    public function store(Request $request,School $school,$class_id)
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

        $class = $school->classes()->findOrFail($class_id);


        $section = $class->sections()->create($attr);

        return $this->response->created($section)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,School $school,$class_id,$section_id)
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

        $class = $school->classes()->findOrFail($class_id);


        $section = $class->sections()->findOrFail($section_id);

        $section->update($attr);

        return $this->response->created($section)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school,$class_id,Section $section)
    {
        $class = $school->classes()->findOrFail($class_id);


        $section = $class->sections()->findOrFail($section->id);

        if($section->delete())
        {

            return $this->response->ok(['Deleted'])->respond();
        }
        else
        {
            return $this->response->notFound()->respond();
        }
    }
}
