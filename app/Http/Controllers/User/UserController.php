<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    
    public function index()
    {
        $users=User::all();
        return response()->json(['data' => $users],200);
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request,$rules);
        $data=$request->all();
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER;
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER;

        $user=User::create($data);
        return response()->json(['data' => $user],201);


    }

   
    public function show(User $user)
    {
        return response()->json(['data' => $user],200);
    }

    public function update(Request $request, User $user)
    {
        // $rules = [
            
        //     'email' => 'email|unique:users',
        //     'password' => 'min:6|confirmed',
        //     'admin'  => 'in' . User::ADMIN_USER . ',' . User::REGULAR_USER,
        // ];
        // $this->validate($request,$rules);
        
        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('email') && $user->email != $request->email ){
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token =User::generateVerificationCode();
            $user->email =$request->email;
        }
        if($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        if($request->has('admin')){
            if(!$user->isVerified()){
                return response()->json(['error' => 'Only verified user can modify the admin field','code'=>409],409);
            }
            $user->admin =$request->admin;
        }
        if(!$user->isDirty()) {
            return response()->json(['error' => 'You need to specify a different value to update','code'=>409],409);
        }
        $user->save();

        return response()->json("Successfully Update",201);
    }

  
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json("Successfully delete",204);
    }
}
