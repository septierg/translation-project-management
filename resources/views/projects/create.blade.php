@extends('layouts.admin')



@section('title')
    Projects
@endsection()


@section('content')


    <div class="container py-4">
         <div class="card shadow-sm">
            <div class="card-header bg-light fw-bold">
                Créer un nouveau projet
            </div>

        <div class="card-body">
            <form method="POST" action="/projects" @submit.prevent="onSubmit">
                @csrf

                <div class="mb-3">
                    <input
                        type="text"
                        name="title"
                        id="title"
                        v-model="title"
                        class="form-control {{ $errors->has('title') ? 'border border-danger' : ''}}"
                        value="{{ old('title') }}"
                        placeholder="Titre du projet"
                        required
                    >

                </div>

                <div class="mb-3">
                    <textarea
                        name="description"
                        id="description"
                        v-model="description"
                        class="{{ $errors->has('description') ? 'border border-danger' : ''}}"
                        placeholder="Description du projet"
                        rows="4"
                    >{{ old('description') }}</textarea>

                </div>


                <div class="form-group">
                    <button  type="submit" class="btn btn-primary">Create project</button>
                </div>

            </form>

         </div>

    </div>

<script src="https://unpkg.com/vue@2.1.6/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@include('errors')

@endsection
