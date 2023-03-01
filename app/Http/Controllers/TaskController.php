<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Notifications\TaskAssigned;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TaskCompleted;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(  Task::get(),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('task.create', [
            'users' => User::latest()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $task['taskcreator_id']=$request->taskcreator_id;
        $task['assigneduser_id']=$request->assigneduser_id;
        $task['title']=$request->title;
        $task['slug']=$request->slug;
        $task['description']=$request->description;
        $task['due']=$request->due;
        $task['completed']=0;
      

      

      if ( Task::create($task)) {
        return response('success', 200);      } 
        else {
            return response(Task::create($task), 400); 
        }

        //$this->notifyUser($task->assigneduser_id);
        
       // return redirect('/')->with('success', 'Task updated and assigned user notified by email');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('task.show', [
            'task' => Task::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('task.edit', [
            'task' => Task::find($id),
            'users' => User::latest()->get()
        ]);
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
        $attributes = $this->validateTask($request);
        $task =  Task::find($id);
        $attributes['taskcreator_id'] = Auth::user()->id;
        $attributes['completed'] = 0;
        $attributes['slug'] = Str::slug($request->title);
        $task->update($attributes);

        $this->notifyUser($task->assigneduser_id);

        return redirect('/task')->with('success', 'Task updated and assigned user notified by email');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete;
        return redirect('/task')->with('success', 'Task Deleted');
    }

    public function validateTask(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required',
            'due' => 'required',
            'description' => 'required',
            'assigneduser_id' => ['required', Rule::exists('users', 'id')]
        ]);

        return $attributes;
    }

    public function completed($id)
    {
        $task = Task::find($id);
        $task->completed = 1;
        $task->update();
        $users = User::where('id', $task->assigneduser_id )
                        ->orWhere('id',$task->taskcreator_id)
                        ->get();
        Notification::send($users, new TaskCompleted($task));
        return redirect('/task')->with('success', 'Task marked completed');
    }

    public function notifyUser($assignedUserId)
    {
        $task = Task::where('assigneduser_id',$assignedUserId)->first();
        $user = User::where('id', $assignedUserId)->first();
        Notification::send($user, new TaskAssigned($task));

        return back()->with('success', 'Task notification email has been sent to the assigned user');
    }

}
