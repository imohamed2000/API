<?php

namespace App\Http\Controllers;

use App\Grade;
use App\School;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \App\Beak\Response
     */
    public function index(Request $request, School $school){
        $data = Grade::with('sections')->orderBy('order', 'asc')->get();
        return $this->response->ok( $data )->respond();
    }

    /**
     * reSort grades of a particular school
     * @param  Request $request
     * @param  School  $school
     * @return \App\Beak\Response
     */
    public function sort(Request $request, School $school){
        $data = [];
        foreach($request->input('grades') as $updated_grade){
            // Data Validation
            $is_valid = $this->validate($updated_grade, [
                'order'	=> 'required|numeric|min:0'
            ]);
            if(!$is_valid)
            {
                return $this->response->badRequest($this->errors)->respond();
            }

            // Updating order
            $grade = \App\Grade::findOrFail( $updated_grade['id'] );
            if($grade->order != $updated_grade['order'])
            {
                $grade->order = $updated_grade['order'];
                $grade->save();
            }
            $data[] = $grade;
        }

        return $this->response->ok( $data )->respond();
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\School  $school
     * @return \App\Beak\Response
     */
    public function store(Request $request, School $school){
        // Validation
        $is_valid = $this->validate($request->all(), [
            'name'		=> 'required',
        ]);
        if(!$is_valid)
        { // Returning validation errors if failed
            return $this->response->badRequest( $this->errors )->respond();
        }

        // Calculating order based on the last inserted grade order
        $last_grade = \App\Grade::where('school_id', $school->id)->orderBy('order', 'desc')->first();
        $order = $last_grade ? $last_grade->order + 1 : 1;

        // Creating a resource
        $grade = \App\Grade::create([
            'name'		=> $request->input('name'),
            'school_id'	=> $school->id,
            'order'		=> $order
        ]);

        // Returning a response
        return $this->response->created( $grade )->respond();
    }

    public function update(Request $request, School $school, $id)
    {
        $is_valid = $this->validate($request->all(),[
            'name'  => 'required|max:255',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'  => $request->name,
        ];

        $grade = $school->grades()->findOrFail($id);


        $grade->update($attr);

        return $this->response->ok($grade)->respond();
    }



    public function destroy(School $school, $id)
    {
        $grade = $school->grades()->findOrFail($id);
        $grade->delete();
        return $this->response->ok(['Deleted'])->respond();

    }

    /**
     * Display Trashed
     * @param \App\School $school
     * @return \App\Beak\Response
     */
    public function trashed(School $school)
    {
        $trashed = $school->grades()->onlyTrashed()->get();
        return $this->response->ok($trashed)->respond();
    }


    /**
     * Restore  specific trashed
     * @param  \App\School  $school
     * @param int $id
     * @return \App\Beak\Response
     */
    public function restore(School $school,$id)
    {
        $grade = $school->grades()->findOrFail($id);
        if($grade->trashed())
        {
            $grade->restore();
            return $this->response->ok($grade)->respond();
        }
        return $this->response->badRequest(['Error request'])->respond();
        
    }
}
