<?php

namespace App\Http\Controllers;

use App\Beak\RoleFilter;
use App\Beak\Upload;
use App\Beak\UserFilters;
use App\Grade;
use App\GradeUser;
use App\School;
use App\Section;
use App\SectionUser;
use App\User;
use App\Year;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $list = ['users.id', 'first_name', 'last_name', 'email'];
    private $default_avatars = [1, 2];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, School $school)
    {
        $data = $school->users()->latest()->select($this->list);
        if ($request->exists('datatables')) {
            return $this->response
                ->dataTables($data->get())
                ->respond();
        }

        if ($request->has('per_page')) {
            $data = $data->paginate($request->input('per_page'));
        } else {
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, School $school)
    {
        $is_valid = $this->validate($request->all(), [
            'role' => 'required|exists:roles,id', // TODO validate that the role is connected to the current school
            'title' => 'max:10',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'date|nullable',
            'phone' => 'max:42',
            'address' => 'max:255',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'avatar' => 'image|nullable'
        ]);

        if (!$is_valid) {
            return $this->response->badRequest($this->errors)->respond();
        }
        if ($request->hasFile('avatar')) {
            $avatar = new Upload;
            $avatar->put($request->file('avatar'), 'users/avatar');
            $avatar = $avatar->getFileData()->id;
        } else {
            if ($request->gender === 'male') {
                $avatar = 1;
            } else {
                $avatar = 2;
            }
        }
        $attr = [
            'title' => $request->title,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $avatar
        ];

        $user = $school->users()->create($attr);

        // save User Role
        $role = \App\Role::find($request->role);
        $user->roles()->save($role);

        return $this->response->created($user)->respond();

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(School $school, $id)
    {
        $data = $school->users()->with('roles')->findOrFail($id);
        return $this->response->ok($data)->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, School $school, $id)
    {
        $user = $school->users()->findOrFail($id);
        $is_valid = $this->validate($request->all(), [
            'role' => 'required|exists:roles,id', // TODO validate that the role is connected to the current school
            'title' => 'max:10',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'birth_date' => 'date|nullable',
            'phone' => 'max:42',
            'address' => 'max:255',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'image|nullable'
        ]);

        if (!$is_valid) {
            return $this->response->badRequest($this->errors)->respond();
        }

        $user->title = $request->title;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->birth_date = $request->birth_date;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;

        // Updating Password
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        // Updating Avatar
        if ($request->hasFile('avatar')) {
            $avatar = new Upload;
            if (in_array($user->avatar, $this->default_avatars)) {
                // Upload new avatar
                $avatar->put($request->file('avatar'), 'users/avatar');
            } else {
                // Override old avatar
                $avatar->replace($user->avatar, $request->file('avatar'));
            }
            $user->avatar = $avatar->getFileData()->id;
        }
        // Clearing Avatar
        if ($request->has('clear_avatar')) {
            $avatar = $user->gender == 'male' ? $this->default_avatars[0] : $this->default_avatars[1];
            $user->avatar = $avatar;
        }
        // Update User Role
        if ($user->role != $request->input('role')) {
            $user->roles()->sync([$request->input('role')]);
        }

        $user->save();
        return $this->response->ok($user)->respond();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(School $school, $id)
    {
        $user = $school->users()->findOrFail($id);
        $user->delete();
        return $this->response->ok(['Deleted'])->respond();
    }

    /**
     * Display Trashed
     * @param \App\School $school
     * @return \App\Beak\Response
     */
    public function trashed(School $school)
    {
        $trashed = $school->users()->onlyTrashed()->get();
        return $this->response->ok($trashed)->respond();
    }

    /**
     * Restore  specific trashed
     * @param  \App\School $school
     * @param int $id
     * @return \App\Beak\Response
     */
    public function restore(School $school, $id)
    {
        $user = $school->users()->findOrFail($id);
        if ($user->trashed()) {
            $user->restore();
            return $this->response->ok($user)->respond();
        }
        return $this->response->badRequest(['Error request'])->respond();
    }

    /**
     * Search Users
     * @param  School $school
     * @param  \App\Beak\UserFilters $userFilter
     * @param  \App\Beak\RoleFilter $roleFilter
     * @return \App\Beak\Response
     */
    public function search(School $school, UserFilters $userFilter, RoleFilter $roleFilter)
    {
        if(request()->has('role'))
        {
            return $school->roles()->filter($roleFilter)->with(['users' => function ($query) use ($userFilter) {
                $query->filter($userFilter);
                }])->paginate(30);
        }
        return $school->users()->filter($userFilter)->paginate(30);
    }

    // Get Sections of specific User
    public function getSection(School $school, User $user)
    {   
        $sections = Section::whereHas('users', function($pivot) use($user){
            $pivot->where('user_id', $user->id);
        })->get();
        return $this->response->ok($sections)->respond();
    }

    // get Users of specific section
    // ## It's better to move this method to the SectionController ##

    public function getUsersSection(School $school,$id)
    {
        $users = SectionUser::where('section_id',$id)->with('users')->get();

        return $this->response->ok($users)->respond();
    }

    public function storeSection(Request $request, School $school, User $user)
    {   
        // Get sections and filter them to remove 0 and empty inputs
        $sections = array_filter( explode(',', $request->input('section')) );
        // Data Validation 
        // TODO Validate that section is related to current school
        //    
        // Errors initialization
        $errors = [
            'section' => ['The grade field is required.']
        ];
        if(!count($sections))
        { // Validating required field
            return $this->response->badRequest($errors)->respond();
        }

        $data = ['section' => $sections];
        $rules = ['section.*'   => 'required|integer|min:1|exists:sections,id'];
        $messages = [];
        $is_valid = $this->validate($data, $rules, $messages);

        if(!$is_valid){
            return $this->response->badRequest($this->errors)->respond();
        }

        // Sync user sections
        $user->sections()->sync( $sections );

        // Response 
        return $this->response->ok($user->sections)->respond();
    }

    /**
     * Get Grade of specific
     * User in active year
     * @param School $school
     * @param User $user
     * @return \App\Beak\Response
     */

    public function getGrade(School $school, User $user)
    {   
        $grades = Grade::where('school_id', $school->id)
                        ->whereHas('users', function($pivot) use($school, $user){
                            $pivot->where('school_id', $school->id)
                                    ->where('user_id', $user->id);
                        })
                        ->get();
        return $this->response->ok($grades)->respond();
    }

    /**
     * Get Users(Students) of
     * grade in active year
     * @param School $school
     * @param Grade $grade
     * @return \App\Beak\Response
     */
    public function getUsersGrade(School $school, Grade $grade)
    {
        $year = $school->years()->where('current',1)->firstOrFail();

        $users = GradeUser::where('grade_id',$grade->id)->where('year_id',$year->id)->with('users')->get();

        return $this->response->ok($users)->respond();
    }

    /**
     * Store User(Student) with
     * grade in active year
     * @param Request $request
     * @param School $school
     * @param User $user
     * @return \App\Beak\Response
     */
    public function storeGrade(School $school,User $user, Request $request)
    {   
        // Get Grades and filter them to remove 0 and empty inputs
        $grades = array_filter( explode(',', $request->input('grade')) );
        // Data Validation 
        // TODO Validate that grade is related to current school
        //    
        // Errors initialization
        $errors = [
            'grade' => ['The grade field is required.']
        ];
        if(!count($grades))
        { // Validating required field
            return $this->response->badRequest($errors)->respond();
        }

        $data = ['grade' => $grades];
        $rules = ['grade.*'   => 'required|integer|min:1|exists:grades,id'];
        $messages = [];
        $is_valid = $this->validate($data, $rules, $messages);

        if(!$is_valid){
            return $this->response->badRequest($this->errors)->respond();
        }

        // Prepare data for sync method
        $year_id = $school->current_year_id;
        $grades = array_map(function($grade) use($year_id){
            return ['year_id' => $year_id];
        }, array_flip( $grades ));

        // Sync user grades
        $user->grades()->sync( $grades );

        // Response 
        return $this->response->ok($user->grades)->respond();
    }
}
