@extends('layouts.admin')
@php
    use Illuminate\Support\Str;
@endphp

@section('title')
    Projets
@endsection

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Projets</h1>
        <a href="/projects/create" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Nouveau projet
        </a>
    </div>

    @if($projects->count())
        <div class="list-group">
            @foreach($projects as $project)
                <a href="/projects/{{ $project->id }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1">{{ $project->title }}</h5>
                        <small class="text-muted text-truncate d-block" style="max-width: 600px;">
                            {{ Str::limit($project->description, 100) }}
                        </small>
                    </div>
                    <i class="bi bi-chevron-right"></i>
                </a>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            Aucun projet trouvé.
        </div>
    @endif

</div>

@endsection
