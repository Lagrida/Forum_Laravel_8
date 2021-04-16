<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    function index(Request $request){
        $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);
        $user= User::where('username', $request->username)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response([
                    'message' => ['Error in username/password.']
                ], 404);
            }
            $token = $user->createToken('my-app-token')->plainTextToken;
            $userRoles = $user->getRoleNames();
            unset($user->roles);
            $user->roles = $userRoles;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 201);
    }
    function store(Request $request){
        $request->validate([
            'username' => ['required', 'unique:users', 'min:3', 'max:20'],
            'password' => ['required', 'min:6'],
            'email' => ['required', 'unique:users', 'email']
        ]);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $created = User::create($data);
        $created->assignRole('user');
        return response($created, 200);
    }
    /*function getProfile(Request $request){
        $user = Auth::user();
        $userRoles = $user->getRoleNames();
        unset($user->roles);
        $user->roles = $userRoles;
        return $user;
    }*/
    function updateProfile(Request $request, $id){
        $user = Auth::user();
        if($user->id == $id){
            $data = $request->only(['email', 'name', 'image', 'birthday', 'gender']);
            if($data['email'] != $user->email){
                $request->validate([
                    'email' => ['required', 'unique:users', 'email']
                ]);
            }
            $user = User::findOrFail($id);
            $user->update($data);
            $token = $user->createToken('my-app-token')->plainTextToken;
            $userRoles = $user->getRoleNames();
            unset($user->roles);
            $user->roles = $userRoles;
            return [
                'user' => $user,
                'token' => $token
            ];
        }else{
            return response(['message' => 'Forbiden, you are not allowed'], 403);
        }
    }
    function getUser($id){
        $user = User::findOrFail($id);
        $userRoles = $user->getRoleNames();
        unset($user->roles);
        $user->roles = $userRoles;
        return $user;
    }
    function getUsers(){
        $users = User::with('roles')->paginate(10);
        return $users;
    }
}
