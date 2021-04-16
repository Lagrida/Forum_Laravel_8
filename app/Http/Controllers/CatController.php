<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class CatController extends Controller
{
    public function __construct(){
        /*$this->
        $this->middleware();*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return Cat::all();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $request->validate([
            'title' => ['required']
        ]);
        $data = $request->all();
        $created = Cat::create($data);
        return response($created, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Cat::findOrFail($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $data = $request->all();
        $cat = Cat::findOrFail($id);
        $cat->update($data);
        return $cat;
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
}
