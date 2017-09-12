<?php

namespace App\Http\Controllers;

use App\Exam;
use App\School;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    private $list = ['id','name','fullmark'];

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @param \App\School $school
     * @return \App\Beak\Response
     */
    public function index(Request $request, School $school)
    {
        $data = Exam::select($this->list)->latest();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School $school
     * @return \App\Beak\Response
     */
    public function store(Request $request, School $school)
    {
        $is_valid = $this->validate($request->all(),[
            'name'              => 'required|max:255',
            'fullmark'          => 'required|integer',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'          => $request->name,
            'description'   => $request->description,
            'fullmark'      => $request->fullmark
        ];

        $exam = Exam::create($attr);

        return $this->response->created($exam)->respond();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @param  \App\School $school
     * @return \App\Beak\Response
     */
    public function show(School $school, Exam $exam)
    {
        return $this->response->ok($exam)->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @param  \App\School $school
     * @return \App\Beak\Response
     */
    public function update(Request $request,School $school, Exam $exam)
    {
        $is_valid = $this->validate($request->all(),[
            'name'              => 'required|max:255',
            'fullmark'          => 'required|integer',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'          => $request->name,
            'description'   => $request->description,
            'fullmark'      => $request->fullmark
        ];

        $exam->update($attr);

        return $this->response->ok($exam)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     *@param  \App\School $school
     * @return \App\Beak\Response
     */
    public function destroy(School $school, Exam $exam)
    {
        $exam->delete();
        return $this->response->ok(['exam'=>'Exam Deleted'])->respond();
    }
}
