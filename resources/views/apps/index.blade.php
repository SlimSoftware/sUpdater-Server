<x-layout title="Apps">
    <a class="btn btn-primary mb-2" href="{{ route('apps.new') }}">Add</a>

    @unless($apps->isEmpty())
        <table class="table table-sm table-striped table-bordered w-auto">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Version</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apps as $app)
                    <tr is="vue:app-item" id="{{ $app->id }}" name="{{ $app->name }}" version="{{ $app->version }}"></tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>No apps available yet</em></p>
    @endunless
</x-layout>