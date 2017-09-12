<?php

namespace App\Http\Controllers;

use App\School;
use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $list = ['id','name','school_id'];
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @param \App\School $school
     * @return \App\Beak\Response
     */
    public function index(Request $request, School $school)
    {
        $subjects = $school->subjects()->select($this->list)->latest();
        // datatables request
        if( $request->exists('datatables') )
        {
            return $this->response
                ->dataTables( $subjects->get() )
                ->respond();
        }

        //pagination request
        if( $request->has('per_page') )
        {
            $subjects = $subjects->paginate( $request->input('per_page') );
        }
        else
        {
            $subjects = $subjects->get();
        }

        return $this->response->ok($subjects)->respond();
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response@param \Illuminate\Http\Request $request
     * @param \App\School $school
     * @return \App\Beak\Response
     */
    public function store(Request $request, School $school)
    {
        $is_valid = $this->validate($request->all(),[
            'name'              => 'required|max:255'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'          => $request->name
        ];
        $subject = $school->subjects()->create($attr);

        return $this->response->created($subject)->respond();

    }

    /**
     * Display the specified resource.
     * @param \App\School $school
     * @param \App\Subject $subject
     * @return \App\Beak\Response
     */
    public function show(School $school,Subject $subject)
    {
        return $this->response->ok($subject)->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\School $school
     * @param  int $id
     * @return \App\Beak\Response
     */
    public function update(Request $request, School $school, $id)
    {
        $is_valid = $this->validate($request->all(),[
            'name'              => 'required|max:255'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'          => $request->name
        ];
        $subject = $school->subjects()->findOrFail($id);

        $subject->update($attr);

        return $this->response->ok($subject)->respond();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\School $school
     * @param  int $id
     * @return \App\Beak\Response
     */
    public function destroy(School $school, $id)
    {
        $subject = $school->subjects()->findOrFail($id);
        $subject->delete();
        return $this->response->ok(['subject'=>'Subject Deleted'])->respond();
    }
}
