<x-layout title="Apps">
    <a class="btn btn-primary mb-2" href="{{ route('apps.new') }}">Add new</a>

    @if (isset($apps))
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apps as $app)
                    <tr>
                        <td class="align-middle">{{ $app->name }}</td>
                        <td class="align-middle">{{ $app->version }}</td>
                        <td><a class="btn btn-primary" href="{{ route('apps.edit', $app->id) }}" >Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>No apps available</b></em>
    @endif
</x-layout>