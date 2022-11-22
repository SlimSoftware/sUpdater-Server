<x-layout title="Edit {{ $app->name }}">
    <x-forms.app :app="$app" :installer="$app->installer" />
</x-layout>