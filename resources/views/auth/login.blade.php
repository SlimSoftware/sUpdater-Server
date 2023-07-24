<x-layout title="Log In">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="col-md-4 mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="user" />
        </div>

        <div class="col-md-4 mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="pass" />
        </div>

        <input class="btn btn-primary" type="submit" value="Log In" />
    </form>
</x-layout>
