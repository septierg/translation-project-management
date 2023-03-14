<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Project;
use \App\Mail\ProjectCreated;

class ProjectsController extends Controller
{
    public function index(){

        /*auth()->id();//no if person is guest if not give me the id
        auth()->user();//whoe is sign in
        auth()->check();//boolean to know true or false
        auth()->guest();;//go for comparaison if guest do something else*/

        //$projects = Project::all();
        //$projects = Project::where('owner_id', auth()->id())->get();

        //WITH RELATIONSHIP
        $projects = auth()->user()->projects;
        return view ('projects.index', compact('projects'));
    }

    public function store(){

        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
        ]);

        $attributes['owner_id'] = auth()->id();
        //OR ($attributes + ['owner_id' => auth()->id()]);
        $project = Project::create($attributes);

        event(new \App\Events\ProjectCreated($project));

        //for admin?
        /*\Mail::to('emmanuel.septier@hotmail.com')->send(
            new ProjectCreated($project)
        );*/
        return redirect('/projects');
    }

    public function create(){
        return view ('projects.create');
    }

    public function show(Project $project){
        //abort_if($project->owner_id !== auth()->id(),403);
        /*if(\Gate::denies('view', $project)){
            abort(403);
        }*/
        $this->authorize('view',$project);
        return view ('projects.show',compact('project'));
    }

    public function update(Project $project){
        $attributes = request()->validate([
            'title' => ['required', 'min:3'],
            'description' => ['required', 'min:3'],
        ]);
        $attributes['owner_id'] = auth()->id();
        $this->authorize('view',$project);
        $project->update($attributes);
        return redirect('/projects');
    }

    public function destroy(Project $project){
        $this->authorize('view',$project);
        $project->delete();
        return redirect('/projects');
    }

    public function edit(Project $project){
        $this->authorize('view',$project);
        return view ('projects.edit',compact('project'));
    }


}
