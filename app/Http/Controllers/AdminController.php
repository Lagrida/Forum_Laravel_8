<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function getUsers(){
        $users = User::with('roles')->paginate(10);
        return $users;
    }
    public function updateUser(Request $request, $id){
        /*if($id == 9 || $id == 10 || $id == 11){
            return response(["message" => "you can't update those users !"], 403);
        }*/
        $request->validate([
            'email' => ['required', Rule::unique('users')->ignore($id), 'email'],
            'username' => ['required', Rule::unique('users')->ignore($id), 'min:3', 'max:20']
        ]);
        $user = User::findOrFail($id);
        $userRoles = $user->getRoleNames();
        unset($user->roles);
        $data = $request->all();
        $role = $data['role'];
        if(!$user->hasRole($role)){
            //delete $userRoles[0]
            $user->removeRole($userRoles[0]);
            //add $role
            $user->assignRole($role);
        }
        $user->update($data);
        return response(["message" => "ok"], 200);
    }
    public function getCats(){
        $cats = DB::table('cats')->orderBy('o_rder', 'asc')->get();
        return $cats;
    }
    public function getCat($id){
        return Cat::findOrFail($id);
    }
    public function updateCat(Request $request, $id){
        $request->validate([
            'title' => ['required'],
            'o_rder' => ['required', 'unique:cats']
        ]);
        $data = $request->all();
        $cat = Cat::findOrFail($id);
        $cat->update($data);
        return $cat;
    }
    public function addCat(Request $request){
        $request->validate([
            'title' => ['required'],
            'o_rder' => ['required', 'unique:cats']
        ]);
        $data = $request->all();
        $created = Cat::create($data);
        return response($created, 200);
    }
    public function deleteUser($id)
    {
        if($id == 9 || $id == 10 || $id == 11){
            return response(["message" => "you can't delete those users !"], 403);
        }
        $user = User::findOrFail($id);
        $user->delete();
        return response(['message' => 'user is deleted successefuly'], 200);
    }
}
