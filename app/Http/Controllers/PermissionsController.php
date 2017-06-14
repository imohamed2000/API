<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class PermissionsController extends Controller
{
    private $list = ['name','created_at'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Permission::select($this->list);
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
    public function store(Request $request)
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

        $permission = Permission::create($attr);


        return $this->response->created($permission)->respond();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::findOrFail($id);

        return $this->response->ok($permission)->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        $permission = Permission::findOrFail($id);
        $permission->update($attr);


        return $this->response->ok($permission)->respond();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);

        if($permission->delete())
        {

            return $this->response->ok(['Deleted'])->respond();
        }
        else
        {
            return $this->response->notFound()->respond();
        }
    }
}
