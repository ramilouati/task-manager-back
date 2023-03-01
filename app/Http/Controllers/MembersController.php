<?php

namespace App\Http\Controllers;

use App\Models\members;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatemembersRequest;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $member['project_id']=$request->project_id;
        $member['user_id']=$request->user_id;
        $member['rank']=$request->rank;
        
      

      

      if ( members::create($member)) {
        return response('success', 200);      } 
        else {
            return response(members::create($member), 400); 
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\members  $members
     * @return \Illuminate\Http\Response
     */
    public function show(members $members)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\members  $members
     * @return \Illuminate\Http\Response
     */
    public function edit(members $members)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemembersRequest  $request
     * @param  \App\Models\members  $members
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatemembersRequest $request, members $members)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\members  $members
     * @return \Illuminate\Http\Response
     */
    public function destroy(members $members)
    {
        //
    }
}
