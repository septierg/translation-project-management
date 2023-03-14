<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use App\Project;

class ProjectTasksController extends Controller
{
    //
    public function update(Task $task){

        $method = request()->has('completed') ? 'complete' : 'incomplete';
        $task->$method();

        return back();
    }

    public function store(Project $project){

        //ADD TASK METHOD IN THE PROJECT MODEL
        $project->addTask(
            request()->validate([
                'body' => ['required', 'min:3'],
            ]));

        return back();
    }
}
