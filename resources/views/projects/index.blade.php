@extends('layouts.admin')



@section('title')
    Projects
@endsection()


@section('content')
    <h1>Projects</h1>


    @foreach($projects as $project)

        <li>
            <a href="/projects/{{ $project->id  }}">
                {{ $project->title }}
            </a>
        </li>

    @endforeach

@endsection
