<form method="POST" class="mb-3">
    @csrf
    <app-form id="{{ isset($id) ? $id : '' }}" />
    
    <input class="btn btn-primary" type="submit" value="Save" />
</form>