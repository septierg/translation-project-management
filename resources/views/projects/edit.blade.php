@extends('layouts.admin')



@section('title')
    Projects
@endsection()


@section('content')

    <div class="container">
        <h1>Edit Project</h1>
        <div class="row">
            <div class="col">
                <form method="POST" action="/projects/{{ $project->id }}">
                    {{ method_field('PATCH') }}
                    @csrf

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Project title" value="{{ $project->title }}" required>

                    </div>

                    <div class="form-group">
                        <textarea  class="form-control" name="description" placeholder="Project description" required>{{ $project->description }}</textarea>

                    </div>


                    <div class="form-group">
                        <button  type="submit" class="btn btn-primary">Update project</button>
                    </div>

            </div>
            <div class="col">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title_en" placeholder="Project title" value="{{ $project->title }}" required>

                </div>

                <div class="form-group">
                    <textarea  class="form-control" name="description-en" placeholder="Project description" required>{{ $project->description }}</textarea>

                </div>





                </form>
            </div>
        </div>
        <div class="row">
            <form method="POST" action="/projects/{{ $project->id }}">
                {{ method_field('DELETE') }}
                @csrf

                <div class="form-group">
                    <button  type="submit" class="btn btn-danger">Delete project</button>
                </div>

            </form>
        </div>
    </div>





    @include('errors')
@endsection
