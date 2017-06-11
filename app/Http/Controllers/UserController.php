<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\School;
use App\Beak\Upload;

class UserController extends Controller
{
    private $list = ['title','first_name','last_name','email'];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,School $school)
    {
        $data = $school->users()->select($this->list);
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
        $path = 'uploads/users/avatar';
        $upload = new Upload('avatar',$path,'add');
        $arr = [
            'title'             => $request->title,
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'birthday'          => $request->birthday,
            'contact_no'        => $request->contact_no,
            'address'           => $request->address,
            'gender'            => $request->gender,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'avatar'            => $upload->savedFile->id
        ];
        $user = $school->users()->create($arr);

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
        $data = $school->users()->findOrFail($id);

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
        $user = $school->users()->findOrFail($id);

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
