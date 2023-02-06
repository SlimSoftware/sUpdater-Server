<form method="POST" class="mb-3">
    <x-forms.app.tabs :isNew="isset($id)" id="{{ isset($id) ? $id : '' }}" active="2" />

    @csrf
    <installer-form id="{{ isset($id) ? $id : '' }}" />
    
    <input class="btn btn-primary" type="submit" value="Save" />
</form>