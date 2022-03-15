<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Todo;

class TodoController extends Controller
{
    
    private const ERROR_500_MESSAGE = 'An error occurred. Please try again later';
    private const USER_DOES_NOT_EXIST = 'Sorry only existing users can create projects';
    private const PROJECT_DOES_NOT_EXIST = 'Sorry only existing projects can have todos';
    private const TODO_DOES_NOT_EXIST = 'Sorry the todo does not exist';
    private const TODO_ALREADY_EXIST = 'Sorry this todo already exists';
    
    // add Todo
    public function addTodo(Request $request) {
        $todo = new Todo;
        $todo->name = $request->name;
        $todo->activity = $request->activity;
        $todo->state = $request->state;
        $todo->dateline = $request->dateline;
        $todo->project = $request->project;
        $todo->owner = $request->owner;

        //check if owner exists
        $owner = DB::table('owners')->where('name', $request->owner)->first();
        if(is_null($owner)) {
            return $this->errorResponse($this::USER_DOES_NOT_EXIST, "ERR-UNAVAILABLE", 404);
        }

        //check if project exists
        $project = DB::table('projects')->where('name', $request->project)->first();
        if(is_null($project)) {
            return $this->errorResponse($this::PROJECT_DOES_NOT_EXIST, "ERR-UNAVAILABLE", 404);
        }

        //check if todo exists
        $todoCheck = DB::table('todos')->where('name', $request->name)->where('project', $request->project)->where('owner', $request->owner)->first();
        if(!is_null($todoCheck)) {
            return $this->errorResponse($this::TODO_ALREADY_EXIST, "ERR-DUPLICATE-ENTRY", 403);
        }

        $todo->save();
        return $this->sendResponse($todo, "Todo successfully created", "TODO-CREATED", 201);
    }

    // get all undone todos
    public function getAllUndoneTodos(Request $request) {
        $todos = DB::table('todos')->where('state', 'undone')->where('project', $request->project)->where('owner', $request->owner)->get();

        return $this->sendResponse($todos, "Todos", "TODO", 201);
    }

    // get all done todos
    public function getAllDoneTodos(Request $request) {
        $todos = DB::table('todos')->where('state', 'done')->where('project', $request->project)->where('owner', $request->owner)->get();

        return $this->sendResponse($todos, "Todos", "TODO", 201);
    }

    // get all started todos
    public function getAllStartedTodos(Request $request) {
        $todos = DB::table('todos')->where('state', 'started')->where('project', $request->project)->where('owner', $request->owner)->get();

        return $this->sendResponse($todos, "Todos", "TODO", 201);
    }

    // update todo
    public function updateTodo(Request $request) {
        $todo = Todo::find($request->id);
        // return $request->state;
        if(is_null($todo)) {
            return $this->errorResponse($this::TODO_DOES_NOT_EXIST, "ERR-UNAVAILABLE", 404);
        }
        
        $todo->state = $request->state;
        $todo->update($request->all());
        return $this->sendResponse($todo, "Todo successfully updated", "TODO-UPDATED", 201);
    }

    // delete submission
    public function deleteTodo(Request $request) {
        $todo = Todo::find($request->id);
        if(is_null($todo)) {
            return $this->errorResponse($this::TODO_DOES_NOT_EXIST, "ERR-UNAVAILABLE", 404);
        }
        $todo->delete();
        return $this->sendResponse($todo, "Todo successfully deleted", "TODO-DELETED", 201);
    }
}
