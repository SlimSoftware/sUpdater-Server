<form method="POST">
    <h3><b>General info</b></h3>
    <p>Name: <input type="text" name="name" value="<?= isset($app["name"]) ? $app["name"] : "" ?>" required /></p>
    <p>Version: <input type="text" name="version" value="<?= isset($app["version"]) ? $app["version"] : "" ?>" required /></p>
    <p>Use this app's own updater to check for updates: <input type="checkbox" name="noupdate" <?= isset($app["noupdate"]) && $app["noupdate"] == 1 ? "checked" : "" ?> /></p>
    <h3><b>Detection Info</b></h3>
    <p>Arch:
        <select name="arch">
            <option value="0" <?= isset($detectInfo["arch"]) && $detectInfo["arch"] == 0 ? "selected" : "" ?>>Any</option>
            <option value="1" <?= isset($detectInfo["arch"]) && $detectInfo["arch"] == 1 ? "selected" : "" ?>>32-bit</option>
            <option value="2" <?= isset($detectInfo["arch"]) && $detectInfo["arch"] == 2 ? "selected" : "" ?>>64-bit</option>
        </select>
    </p>
    <p>Registry key: <input type="text" name="regkey" value="<?= isset($detectInfo["regkey"]) ? $detectInfo["regkey"] : "" ?>" /></p>
    <p>Registry value: <input type="text" name="regvalue" value="<?= isset($detectInfo["regvalue"]) ? $detectInfo["regvalue"] : "" ?>" /></p>
    <p>Executable path: <input type="text" name="exepath" value="<?= isset($detectInfo["exepath"]) ? $detectInfo["exepath"] : "" ?>" /></p>
    <h3><b>Installer Info</b></h3>
    <p>Download link: <input type="text" name="dl" value="<?= isset($installer["dl"]) ? $installer["dl"] : "" ?>" required /></p>
    <p>Launch arguments: <input type="text" name="launchargs" value="<?= isset($installer["launch_args"]) ? $installer["launch_args"] : "" ?>" required /></p>
    <input type="hidden" name="id" value="<?= isset($_GET["id"]) ? $_GET["id"] : "" ?>" />
    <input type="submit" value="Edit app" />
</form>