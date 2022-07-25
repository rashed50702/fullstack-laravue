<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Auth::user();
        if(!Auth::check() && $request->path() != 'login')
        {
            return redirect('/login');
        }

        if(!Auth::check() && $request->path() == 'login'){
            return view('app');
        }


        ///if you are logged in and an admin user
        $user = Auth::user();
        if($user->userType == 'User' && $request->path() != 'login')
        {
            return redirect('/login');
        }
        if($user->userType != 'User' && $request->path() == 'login')
        {
            return redirect('/');
        }
        
        // return view('app');

        return $this->checkForPermission($user, $request);
    }

    public function checkForPermission($user, $request)
    {
        $permission = json_decode($user->role->permission);

        if(!$permission) return view('app');

        $hasPermission = false;

        foreach($permission as $p){
            if($p->name == $request->path()){
                if($p->read){
                    $hasPermission = true;
                }
            }
        }

        if($hasPermission){
            return view('app');
        }else{
            return view('errors/404');
        }
    }


    public function adminUserList()
    {
        return User::with('role')->get();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
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
        // $this->validate($request, [
        //     'fullName' => 'required',
        //     'email' => 'required|unique:users',
        //     'password' => 'required|min:6',
        //     'email' => 'required|email|unique:users',
        // ]);

        $validator = Validator::make($request->all(), [
            'fullName' => 'required',
            'email' => 'bail|required|email|unique:users',
            'password' => 'bail|required|min:6',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }

        $password = Hash::make($request->password);
        
        $data = User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required',
            'email' => 'bail|required|unique:users,email,' . $request->id,
            'password' => 'nullable|min:6',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }

        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if($request->password){
            $password = Hash::make($request->password);
            $data['password'] = $password;
        }

        $data = User::where('id', $request->id)->update($data);

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function adminLogin(Request $request)
    {
        // return $request->all();
        // $this->validate($request, [
        //     'email' => 'required|email',
        //     'password' => 'required|min:6',
        // ]);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return Response::json(['errors' => $validator->errors()->all(), 'status' => 422]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return Response::json([
                'msg' => 'You are logged in!'
            ]);
        }else{
            return Response::json([
                'msg' => 'Incorrect login details!'
            ], 401);
        }
    }
}
