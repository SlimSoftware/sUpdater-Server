<x-layout title="Edit App">
    <app-form id="{{ $id }}">
        <template #csrf>
            {{ csrf_field() }}
        </template>
    </app-form>
</x-layout>