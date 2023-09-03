<x-layout title="Log In">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="col-md-4 mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}"
                required />

            @foreach ($errors->get('username') as $message)
                <div class="text-danger tw-bold">{{ $message }}</div>
            @endforeach
        </div>

        <div class="col-md-4 mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="current-password"
                required />

            @foreach ($errors->get('password') as $message)
                <div class="text-danger tw-bold">{{ $message }}</div>
            @endforeach
        </div>

        <input class="btn btn-primary" type="submit" value="Log In" />
    </form>
</x-layout>
