<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

class GradeController extends Controller
{	
	/**
	 * Display a listing of the resource.
	 * @return \App\Beak\Response
	 */
    public function index(Request $request, School $school){
    	$data = $school->grades()->orderBy('order', 'asc')->get();
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
}
