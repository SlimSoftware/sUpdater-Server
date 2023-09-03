<li class="nav-item">
    <a @class(['nav-link', 'active' => Route::is($routeName)])
        href="{{ route($routeName) }}">
        {{ $pageTitle }}
    </a>
</li>