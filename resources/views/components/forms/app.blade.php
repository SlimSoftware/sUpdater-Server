<form method="POST" class="mb-3">
    @csrf
    <app-form :app='@json($app)' />
    
    <input class="btn btn-primary" type="submit" value="Save" />
</form>