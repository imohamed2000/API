<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\School;
use App\Beak\Upload;

class UserController extends Controller
{
    private $list = ['users.id','first_name', 'last_name','email'];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,School $school)
    {   
        $data = $school->users()->latest()->select($this->list);
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
            'role'              => 'required|exists:roles,id', // TODO validate that the role is connected to the current school
            'title'             => 'max:10',
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'birth_date'        => 'date',
            'phone'             => 'max:42',
            'address'           => 'max:255',
            'gender'            => 'required|in:male,female',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:6',
            'avatar'            => 'image'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }
        if($request->hasFile('avatar'))
        {   
            $avatar = new Upload;
            $avatar->put( $request->file('avatar'), 'users/avatar' );
            $avatar = $avatar->getFileData()->id;
        }
        else
        {
            if($request->gender === 'male'){
                $avatar = 1;
            }
            else
            {
                $avatar = 2;
            }
        }
        $attr = [
            'title'             => $request->title,
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'birth_date'        => $request->birth_date,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'gender'            => $request->gender,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'avatar'            => $avatar
        ];

        $user = $school->users()->create($attr);

        // save User Role
        $role = \App\Role::find( $request->role );
        $user->roles()->save( $role );

        return $this->response->created($user)->respond();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(School $school,$id)
    {
        $data = $school->users()->with('roles')->findOrFail($id);

        return $this->response->ok($data)->respond();
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
    public function update(Request $request,School $school, $id)
    {
        $is_valid = $this->validate($request->all(),[
            'role'              => 'required|exists:roles,id',
            'title'             => 'max:4',
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'birthday'          => 'date',
            'contact_no'        => 'max:42',
            'address'           => 'max:255',
            'gender'            => 'required|in:male,female',
            'email'             => 'required|email',
            'avatar'            => 'image'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $user = $school->users()->findOrFail($id);

        $user->title        = $request->title;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->birthday     = $request->birthday;
        $user->contact_no   = $request->contact_no;
        $user->address      = $request->address;
        $user->gender       = $request->gender;
        $avatar = $user->avatar;
        if($request->exists('avatar'))
        {
            $upload = new Upload('avatar','userAvatar','edit',$user->avatar);
            $avatar = $upload->savedFile->id;
        }
        $user->avatar = $avatar;

        $checkEmail = User::where('email',$request->email)->where('id','!=',$user->id)->first();
        if($checkEmail)
        {
            $errorMsg = ['email'=>'The email is already taken.'];
            return $this->response->badRequest($errorMsg)->respond();
        }


        // Update User Role
        $role = $request->role;
        $user->roles()->sync($role);

        $user->save();
        return $this->response->ok($user)->respond();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school,$id)
    {
        $user = $school->users()->findOrFail($id);
        $user->delete();
        return $this->response->ok(['Deleted'])->respond();
    }
}
