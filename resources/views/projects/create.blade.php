@extends('layouts.admin')



@section('title')
    Projects
@endsection()


@section('content')


    <div class="container">
        <h1>Create a New Project</h1>

        <form method="POST" action="/projects">
            @csrf

            <div class="form-group">
                <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'border border-danger' : ''}}" value="{{ old('title') }}" placeholder="Project title" required>
            </div>

            <div class="form-group">
                <textarea  name="description" class="form-control {{ $errors->has('description') ? 'border border-danger' : ''}}" placeholder="Project description" required>{{ old('description') }}</textarea>

            </div>

            <div class="form-group">
                <button  type="submit" class="btn btn-primary">Create project</button>
            </div>

        </form>

    </div>



@include('errors')

@endsection
