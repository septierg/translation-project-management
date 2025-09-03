@extends('layouts.admin')

@section('title')
    Projects
@endsection

@section('content')

<div class="container py-4">

    {{-- Titre du projet --}}
    <div class="mb-4">
        <h1 class="mb-1">{{ $project->title }}</h1>
        <p class="text-muted">{{ $project->description }}</p>
        <a href="/projects/{{ $project->id }}/edit" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-pencil"></i> Modifier le projet
        </a>
    </div>

    {{-- Liste des tâches --}}
    @if($project->tasks->count())
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                Tâches
            </div>
            <div class="card-body">
                @foreach($project->tasks as $task)
                    <form method="POST" action="/tasks/{{ $task->id }}" class="mb-3">
                        @method('PATCH')
                        @csrf

                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="completed"
                                id="task-{{ $task->id }}"
                                onchange="this.form.submit()"
                                {{ $task->completed ? 'checked' : '' }}
                            >
                            <label class="form-check-label {{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}"
                                for="task-{{ $task->id }}">
                                {{ $task->body }}
                            </label>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Formulaire d'ajout de tâche --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">
            Ajouter une nouvelle tâche
        </div>
        <div class="card-body">
            <form method="POST" action="/projects/{{ $project->id }}/tasks">
                @csrf

                <div class="mb-3">
                    <input
                        type="text"
                        class="form-control"
                        name="body"
                        id="body"
                        placeholder="Saisissez une nouvelle tâche"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Créer la tâche
                </button>

                @include('errors')
            </form>
        </div>
    </div>

</div>

@endsection
