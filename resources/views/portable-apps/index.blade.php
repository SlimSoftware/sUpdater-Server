<x-layout title="Portable Apps">
    <a class="btn btn-primary mb-2" href="{{ route('portable_apps.new') }}">Add new</a>

    @unless($portableApps->isEmpty())
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Version</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($portableApps as $portableApp)
                    <tr>
                        <td class="align-middle">{{ $portableApp->name }}</td>
                        <td class="align-middle">{{ $portableApp->version }}</td>
                        <td><a class="btn btn-primary" href="{{ route('portable_apps.edit', $portableApp->id) }}" >Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>No Portable Apps available yet</em></p>
    @endunless
</x-layout>