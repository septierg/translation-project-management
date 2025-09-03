@extends('layouts.admin')

@section('title')
    Éditer le projet
@endsection

@section('content')

<div class="container py-4">

    <h1 class="mb-4">Modifier le projet</h1>

    {{-- Formulaire d'édition --}}
    <form method="POST" action="/projects/{{ $project->id }}">
        @method('PATCH')
        @csrf

        <div class="row g-4">

            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light fw-bold">Français</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Titre</label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Titre du projet"
                                value="{{ old('title', $project->title) }}"
                                required
                            >

                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                name="description"
                                id="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Description du projet"
                                rows="5"
                                required
                            >{{ old('description', $project->description) }}</textarea>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Mettre à jour le projet
            </button>
        </div>
    </form>

    {{-- Formulaire suppression --}}
    <form method="POST" action="/projects/{{ $project->id }}" class="mt-4">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce projet ?')">
            <i class="bi bi-trash"></i> Supprimer le projet
        </button>
    </form>

    @include('errors')

</div>

@endsection
