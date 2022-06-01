<?php
include_once(__DIR__ . "\..\..\Config.php");
$dir = Config::SERVER_SUBDIR . "/dashboard";
$filename = basename($_SERVER['SCRIPT_NAME']);
?>

<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="<?= "$dir/index.php" ?>">
		<img src="<?= "$dir/img/brand.png" ?>" width="32" height="32" class="d-inline-block align-top" alt="">
		sUpdater Server
	</a>
	<?php
	if (isset($_SESSION["user"])):
	?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav me-auto">
			<li class="nav-item">
				<a class="nav-link <?= $filename === "index.php" ? "active" : "" ?>" href="<?= "$dir/index.php" ?>">Home</a>
			</li>
            <li class="nav-item">
				<a class="nav-link <?= $filename === "apps.php" ? "active" : "" ?>" href="<?= "$dir/apps.php" ?>">Apps</a>
			</li>
		</ul>
		<ul class="navbar-nav my-2 my-md-0">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" 
					aria-haspopup="true" aria-expanded="false">
					Hi <?= $_SESSION["user"] ?>
				</a>
				<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          			<li><a class="dropdown-item" href="<?= "$dir/logout.php" ?>">Log out</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<?php endif; ?>
</nav>
