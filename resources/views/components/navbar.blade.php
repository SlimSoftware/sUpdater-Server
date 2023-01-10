@php
    $routes = [
        'apps' => 'Apps', 
        'portable_apps' => 'Portable Apps'
    ];
@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<div class="container-fluid">
		<a class="navbar-brand" href="/">
			<img src="/img/brand.png" width="32" height="32" class="d-inline-block align-top" alt="">
			{{ config('app.name') }}
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto">
				@foreach ($routes as $routeName => $pageTitle)
					<x-navItem :route-name="$routeName" :page-title="$pageTitle" />
				@endforeach
			</ul>
			{{-- <ul class="navbar-nav my-2 my-md-0">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" 
						aria-haspopup="true" aria-expanded="false">
						Hi <?= $_SESSION["user"] ?>
					</a>
					<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
						<li><a class="dropdown-item" href="<?= "$dir/logout.php" ?>">Log out</a></li>
					</ul>
				</li>
			</ul> --}}
		</div>
	</div>
</nav>