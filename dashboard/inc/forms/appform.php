<form method="POST">
    <h5><b>General info</b></h5>
    <div class="form-group col-md-3">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="nameInput" name="name" value="<?= isset($app["name"]) ? $app["name"] : "" ?>" required />
    </div>

    <div class="form-group col-md-3">
        <label for="versionInput">Version</label>
        <input type="text" class="form-control" id="versionInput" name="version" value="<?= isset($app["version"]) ? $app["version"] : "" ?>" required /></p>
    </div>
    
    <div class="frm-check">
        <input type="checkbox" id="noupdateCheckbox" name="noupdate" class="form-check-input" 
            <?= isset($app["noupdate"]) && $app["noupdate"] == 1 ? "checked" : "" ?> />
        <label for="noupdateCheckbox" class="form-check-label">Use this app's own updater to check for updates</label>
    </div>

    <h5><b>Detection Info</b></h5>
    <div class="form-group col-md-2">
        <label for="archSelect">Arch</label>
        <select class="form-select" id="archSelect" name="arch">
            <option value="0" <?= isset($detectInfo["arch"]) && $detectInfo["arch"] == 0 ? "selected" : "" ?>>Any</option>
            <option value="1" <?= isset($detectInfo["arch"]) && $detectInfo["arch"] == 1 ? "selected" : "" ?>>32-bit</option>
            <option value="2" <?= isset($detectInfo["arch"]) && $detectInfo["arch"] == 2 ? "selected" : "" ?>>64-bit</option>
        </select>
    </div>

    <div class="form-group">
        <label for="regKeyInput">Registry key</label>
        <input type="text" class="form-control" id="regKeyInput" name="regkey" value="<?= isset($detectInfo["regkey"]) ? $detectInfo["regkey"] : "" ?>" />
    </div>

    <div class="form-group col-md-3">
        <label for="regValueInput">Registry value</label>
        <input type="text" class="form-control" id="regValueInput" name="regvalue" value="<?= isset($detectInfo["regvalue"]) ? $detectInfo["regvalue"] : "" ?>" />
    </div>

    <div class="form-group">
        <label for="exePathInput">Executable path</label>
        <input type="text" class="form-control" id="exePathInput" name="exepath" value="<?= isset($detectInfo["exepath"]) ? $detectInfo["exepath"] : "" ?>" />
        <details>
            <summary>Available variables</summary>
            <p>%pf64% = Program Files on 64 bit systems, does not detect on 32 bit systems<br/>
            %pf32% = Program Files (x86) on 64 bit systems, Program Files on 32 bit systems</p?>
        </details>
    </div>

    <h5><b>Installer Info</b></h5>
    <div class="form-group">
        <label for="dlInput">Download link</label>
        <input type="text" class="form-control" id="dlInput" name="dl" value="<?= isset($installer["dl"]) ? $installer["dl"] : "" ?>" required />
    </div>

    <div class="form-group col-md-3">
        <label for="launchArgsInput">Launch arguments</label>
        <input type="text" class="form-control" id="launchArgsInput" name="launchargs" value="<?= isset($installer["launch_args"]) ? $installer["launch_args"] : "" ?>" required />
    </div>

    <input type="hidden" name="id" value="<?= isset($_GET["id"]) ? $_GET["id"] : "" ?>" />
    <input class="btn btn-primary" type="submit" value="Save" />
</form>