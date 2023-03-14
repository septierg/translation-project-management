@component('mail::message')
# Project created {{ $project->title }}

The body of your message create :
{{ $project->description }}

@component('mail::button', ['url' => url('/projects/' .$project->id)])
View project
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
