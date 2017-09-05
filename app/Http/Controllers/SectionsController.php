<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;
use App\School;

class SectionsController extends Controller
{
    private $list = ['id','name','grade_id'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,School $school)
    {
        $data = $school->sections()->select($this->list)->with('grade');
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
            'grade_id'         => 'required|exists:grades,id'
            ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $school->grades()->findOrFail($request->grade_id);

        $attr = [
            'name'              => $request->name,
            'grade_id'          => $request->grade_id,
            'school_id'         => $school->id
        ];
        $section = Section::create($attr);

        return $this->response->created($section)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(School $school, $id)
    {
        $section = $school->sections()->with('grade')->findOrFail($id);
        return $this->response->ok($section)->respond();
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
    public function update(Request $request,School $school,$id)
    {
        $is_valid = $this->validate($request->all(),[
            'name'             => 'required|max:255',
            'grade_id'         => 'required|exists:grades,id'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $school->grade()->findOrFail($request->grade_id);

        $section = $school->sections()->findOrFail($id);

        $attr = [
            'name'              => $request->name,
            'grade_id'          => $request->grade_id,
        ];

        $section->update($attr);

        return $this->response->ok($section)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school,$id)
    {
        $section = $school->sections()->findOrFail($id);
        $section->delete();
        return $this->response->ok(['Deleted'])->respond();
    }
}
