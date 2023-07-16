<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Task as TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TaskController extends BaseController
{
    //

    public function index(){
        $userid = Auth::user()->id;
        $tasks = Task::all()->where('user_id',$userid);
        return $this->handleResponse(TaskResource::collection($tasks),"Task has been retrieved!");
    }

    public function store(Request $request){
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required',
            'details'=> 'required',
            
        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());
        }
        $input['user_id']= Auth::user()->id;
        $task = Task::create($input);
        return $this->handleResponse(new TaskResource($task),'Task created ');
    }

    public function show($id){
        $userid = Auth::user()->id;
        $task = Task::where('user_id',$userid)->find($id);
        if(is_null($task)){
            return $this->handleError("Task not found");
        }
        return $this->handleResponse(new TaskResource($task),"Task retrieved");
    }

    public function edit($id){
        $task = Task::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if(is_null($task)){
            return $this->handleError("Task not found!!");
        }
        return $this->handleResponse(new TaskResource($task),"Task retrieved");
    }

    public function update(Request $request,$id){
        
        $input = $request->all();
        $validator = Validator::make($input,[
            'name' => 'required',
            'details' => 'required',

        ]);
        if($validator->fails()){
            return $this->handleError($validator->errors());
        }
        $userid= Auth::user()->id;
        $task= Task::where('user_id',$userid)->find($id);
        $task->update($input);

        return $this->handleResponse(new TaskResource($task),'Task successfully update');
    
    }
    
    public function destory($id){
        $userid = Auth::user()->id;
       $task = Task::where('user_id',$userid)->where('id',$id)->first();
       
        $task->delete();
        return $this->handleResponse([],'Task deleted successfully');
       

    }
}
