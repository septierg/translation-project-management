@extends('layouts.admin')



@section('title')
    Projects
@endsection()


@section('content')
    <h1> {{ $project->title }}</h1>


    <div class="container">
        {{ $project->description }}

        <p>
            <a href="/projects/{{ $project->id }}/edit">Edit</a>
        </p>

    </div>

    @if($project->tasks->count())
        <div class="container">
            @foreach($project->tasks as $task)

                    <form method="POST" action="/tasks/{{ $task->id }}">
                        @method('PATCH')
                        @csrf

                        <div class="form-check">
                            <label class="form-check-label {{ $task->completed ? 'is-complete' : '' }}"  for="completed" >

                                <input class="form-check-input" type="checkbox" value="" name="completed" id="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                {{ $task->body }}
                            </label>

                        </div>
                    </form>


            @endforeach

        </div>
    @endif

    <div class="container" style="padding-top:15px">
            <form method="POST" action="/projects/{{ $project->id }}/tasks">
                @csrf
                <div class="form-group">
                    <label class="form-check-label"  for="body" >

                        <input type="text" value="" name="body" id="body" placeholder="New task" required>

                    </label>

                </div>

                <div class="form-group">
                    <button  type="submit" class="btn btn-primary">Create Task</button>
                </div>

                @include('errors')

            </form>
    </div>


@endsection
