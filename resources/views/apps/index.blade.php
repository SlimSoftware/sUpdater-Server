<x-layout title="Apps">
    <a class="btn btn-primary mb-2" href="{{ route('apps.new') }}">Add new</a>

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
                    <tr>
                        <td class="align-middle w-75">{{ $app->name }}</td>
                        <td class="align-middle w-25">{{ $app->version }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="{{ route('apps.edit', $app->id) }}">
                                <i class="bi-pencil-fill"></i>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('apps.delete', $app->id) }}" method="POST">
                                @method('DELETE')
                                @csrf

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>No apps available yet</em></p>
    @endunless
</x-layout>