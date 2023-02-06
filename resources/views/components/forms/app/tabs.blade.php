<ul class="nav nav-tabs">
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active == 0]) aria-current="page" href="{{ route('apps.edit', $id) }}">General</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active == 1, 'disabled' => !$isNew]) href="{{ route('apps.edit.detectinfo', $id) }}">Detection</a>
    </li>
    <li class="nav-item">
        <a @class(['nav-link', 'active' => $active == 2, 'disabled' => !$isNew]) href="{{ route('apps.edit.installers', $id) }}">Installers</a>
    </li>
</ul>