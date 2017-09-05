<?php

namespace App\Http\Controllers;

use App\Year;
use Illuminate\Http\Request;
use App\School;

class YearController extends Controller
{
    private $list = ['name','current'];


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
        $is_valid = $this->validate($request->all(),[
            'name'              => 'required|max:255',
            'current'           => 'boolean',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'              => $request->name,
            'current'           => $request->current,
        ];
        if($request->current)
        {
            $school->years()->update(['current' => 0]);
        }
        $year = $school->years()->create($attr);

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
        $is_valid = $this->validate($request->all(),[
            'name'              => 'required|max:255',
            'current'           => 'boolean',
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $attr = [
            'name'              => $request->name,
            'current'           => $request->current,
        ];
        if($request->current)
        {
            $school->years()->update(['current' => 0]);
        }

        $year = $school->years()->findOrFail($id);

        $year->update($attr);

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
        $year = $school->years()->findOrFail($id);
        $year->delete();
        return $this->response->ok(['Deleted'])->respond();
    }

    public function postCurrent(School $school, Year $year)
    {
        $check = $school->years()->findOrFail($year->id);

        $school->years()->update(['current' => 0]);

        $check->update([ 'current' => 1 ]);

        return $this->response->ok(['Done'])->respond();
    }
}
