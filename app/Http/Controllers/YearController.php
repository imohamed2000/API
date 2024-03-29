<?php

namespace App\Http\Controllers;

use App\Year;
use Illuminate\Http\Request;
use App\School;

class YearController extends Controller
{
    private $list = ['id','name','current'];


    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param School $school
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, School $school)
    {
        $data = $school->years()->select($this->list);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, School $school)
    {   
        // Data Validation
        $is_valid = $this->validate(
                $request->only('name'),
                [
                    'name'  => 'required|max:255'
                ]
            );
        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }
        // Creating a new resource
        $attr = [
            'school_id' => $school->id,
            'name'      => $request->input('name')
        ];
        $year = Year::create($attr);
        // Response 
        return $this->response->created($year)->respond();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(School $school, $id)
    {
        $year = $school->years()->findOrFail($id);

        return $this->response->ok($year)->respond();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school, $id)
    {   
        // Data Validation
        $is_valid = $this->validate(
                $request->only('name'),
                [
                    'name'  => 'required|max:255'
                ]
            );
        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }
        // Resource update
        $year = Year::findOrFail( $id );
        $year->update([
                'name'  => $request->input('name')
            ]);
        // Response 
        return $this->response->ok($year)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy( School $school , $id)
    {
        $year = Year::findOrFail($id);
        if($year->current != 1)
        {
            $year->delete();
            return $this->response->ok($year)->respond();
        }
        else
        {
            return $this->response->badRequest(['year'=>'Active Academic year can not be deleted.'])->respond();
        }
    }

    public function postCurrent(School $school, Year $year)
    {   
        // Get current active year
        $current_year = $school->years()->where('current',1)->first();
        // Processing the two cases of (The school has an active year, or do not have at all)
        if($current_year && $current_year->id != $year->id)
        {
            // Set old current to false
            $current_year->update(['current' => 0]);
        }
        // Set new Current to True
        $year->update(['current'=>1]);
        // Response
        return $this->response->ok($year)->respond();
    }
}
