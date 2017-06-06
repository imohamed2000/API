<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\School;
use App\SchoolUser;
use App\Beak\Upload;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,School $school)
    {
        $data = SchoolUser::where('school_id',$school->id)->with('users');
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
            'title'             => 'required|max:4',
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'birthday'          => 'required|date',
            'contact_no'        => 'required|max:42',
            'address'           => 'required|max:255',
            'gender'            => 'required|max:6',
            'email'             => 'required|unique:users,email',
            'password'          => 'required|min:6',
            'confirm_password'  => 'required|same:password',
            'avatar'            => 'required|image'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $user = new User();

        $user->title        = $request->title;
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->birthday     = $request->birthday;
        $user->contact_no   = $request->contact_no;
        $user->address      = $request->address;
        $user->gender       = $request->gender;
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password);

        $path = 'uploads/users/avatar';
        $upload = new Upload('avatar',$path,'add');

        $user->avatar = $upload->savedFile->id;

        $user->save();

        $schoolUser = new SchoolUser();
        $schoolUser->user_id = $user->id;
        $schoolUser->school_id = $school->id;
        $schoolUser->save();

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
        $data = SchoolUser::where('school_id',$school->id)->where('user_id',$id)->with('users')->first();

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
            'title'             => 'required|max:4',
            'first_name'        => 'required|max:255',
            'last_name'         => 'required|max:255',
            'birthday'          => 'required|date',
            'contact_no'        => 'required|max:42',
            'address'           => 'required|max:255',
            'gender'            => 'required|max:6',
            'email'             => 'required|email',
            'avatar'            => 'image'
        ]);

        if(!$is_valid)
        {
            return $this->response->badRequest($this->errors)->respond();
        }

        $user = SchoolUser::where('school_id',$school->id)->where('user_id',$id)->first()->users()->first();

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
            $path = 'uploads/users/avatar';
            $upload = new Upload('avatar',$path,'edit',$user->avatar);

            $avatar = $upload->savedFile->id;
        }
        $user->avatar = $avatar;

        $checkEmail = User::where('email',$request->email)->where('id','!=',$user->id)->first();
        if($checkEmail)
        {
            $errorMsg = ['email'=>'The email is already taken.'];
            return $this->response->badRequest($errorMsg)->respond();
        }

        $user->save();

        return $this->response->created($user)->respond();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school,$id)
    {
        $user = SchoolUser::where('school_id',$school->id)->where('user_id',$id)->first()->users()->first();

        if($user->delete())
        {

            return $this->response->ok(['Deleted'])->respond();
        }
        else
        {
            return $this->response->notFound()->respond();
        }
    }
}
