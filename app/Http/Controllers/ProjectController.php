<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Http\Requests\StoreprojectRequest;
use App\Http\Requests\UpdateprojectRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = project::get();
        return response(project::get(), 200);
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
     * @param  \App\Http\Requests\StoreprojectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreprojectRequest $request)
    {


        // project::create($request->all());

        return response(project::create($request->all()), 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response(project::where("id", $id)->get(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
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
    public function update(Request $request, $id)


    {
        $project =  project::where("id", $id)->get();
        $req = $project->update(
            [
                "title" => $request["title"],
                "description" => $request["description"],
                "completed" => $request["completed"],

            ]



        );
        return response($req, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(project $project)
    {
        //
    }
}
