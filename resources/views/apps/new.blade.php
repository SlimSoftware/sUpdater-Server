<x-layout title="Add App">
    <app-form>
        <template #csrf>
            {{ csrf_field() }}
        </template>
    </app-form>
</x-layout>