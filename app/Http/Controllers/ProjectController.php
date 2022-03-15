<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;

class ProjectController extends Controller
{
    private const ERROR_500_MESSAGE = 'An error occurred. Please try again later';
    private const USER_DOES_NOT_EXIST = 'Sorry only existing users can create projects';
    
    // add Project
    public function addProject(Request $request) {
        $project = new Project;
        $project->name = $request->name;
        $project->owner = $request->owner;

        $owner = DB::table('owners')->where('name', $request->owner)->first();
        if(is_null($owner)) {
            return $this->errorResponse($this::USER_DOES_NOT_EXIST, "ERR-UNAVAILABLE", 404);
        }

        $project->save();
        return $this->sendResponse($project, "Project successfully created", "PROJECT-CREATED", 201);
    }
}
