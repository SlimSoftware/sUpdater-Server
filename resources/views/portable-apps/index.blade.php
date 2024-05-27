<x-layout title="Portable Apps">
    <h1 class="d-inline">Portable Apps</h1>
    <a class="btn btn-primary ms-3 mb-3" style="cursor: not-allowed">Add</a>

    @unless ($portableApps->isEmpty())
        <table class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th class="w-100">Name</th>
                    <th>Version</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($portableApps as $portableApp)
                    <tr>
                        <td class="align-middle">{{ $portableApp->name }}</td>
                        <td class="align-middle">{{ $portableApp->version }}</td>
                        <td>
                            <a class="btn btn-primary btn-sm" style="cursor: not-allowed">
                                <i class="bi-pencil-fill"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger btn-sm" style="cursor: not-allowed">
                                <i class="bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p><em>No Portable Apps available yet</em></p>
    @endunless
</x-layout>

<style>
    th,
    td {
        padding: 5px 7.5px !important;
    }
</style>
