<form method="POST" class="mb-3">
    @csrf

    <h5><b>General</b></h5>
    <div class="mb-3 col-md-3">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="nameInput" name="name" 
            value="{{ isset($app->name) ? $app->name : '' }}" required />
    </div>

    <div class="mb-3 col-md-3">
        <label for="versionInput">Version</label>
        <input type="text" class="form-control" id="versionInput" name="version" onchange="updateDLHint()" 
            value="<?= isset($app["version"]) ? $app["version"] : "" ?>" required /></p>
    </div>
    
    <div class="frm-check mb-2">
        <input type="checkbox" id="noupdateCheckbox" name="noupdate" 
            class="form-check-input" @checked(isset($app->noupdate) && $app->noupdate) />
        <label for="noupdateCheckbox" class="form-check-label">Use this app's own updater to check for updates</label>
    </div>

    <div class="mb-3">
        <label for="releaseNotesInput">Release notes URL</label>
        <input type="text" class="form-control" id="releaseNotesInput" name="releaseNotesUrl" 
            value="{{ isset($app->release_notes_url) ? $app->release_notes_url : '' }}" />
    </div>

    <div class="mb-3">
        <label for="websiteInput">Website URL</label>
        <input type="text" class="form-control" id="websiteInput" name="websiteUrl" 
            value="{{ isset($app->website_url) ? $app->website_url : '' }}" />
    </div>

    <h5><b>Detect info</b></h5>
    <div class="mb-3 col-md-2">
        <label for="archSelect">Arch</label>
        <select class="form-select" id="archSelect" name="arch">
            <option value="0" @selected(isset($app->detectInfo) && $app->detectInfo->arch === 0)>Any</option>
            <option value="1" @selected(isset($app->detectInfo) && $app->detectInfo->arch === 1)>32-bit</option>
            <option value="2" @selected(isset($app->detectInfo) && $app->detectInfo->arch === 2)>64-bit</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="regKeyInput">Registry key</label>
        <input type="text" class="form-control" id="regKeyInput" name="regKey" 
            value="{{ isset($app->detectInfo) ? $app->detectInfo->reg_key : '' }}" />
    </div>

    <div class="mb-3 col-md-3">
        <label for="regValueInput">Registry value</label>
        <input type="text" class="form-control" id="regValueInput" name="regValue" 
            value="{{ isset($app->detectInfo) ? $app->detectInfo->reg_value : '' }}" />
    </div>

    <div class="mb-3">
        <label for="exePathInput">Executable path</label>
        <input type="text" class="form-control" id="exePathInput" name="exePath" 
            value="{{ isset($app->detectInfo) ? $app->detectInfo->exe_path : '' }}" />
        <details>
            <summary>Available variables</summary>
            <p>%pf64% = Program Files on 64 bit systems, does not detect on 32 bit systems<br/>
            %pf32% = Program Files (x86) on 64 bit systems, Program Files on 32 bit systems</p>
        </details>
    </div>

    <h5><b>Installer Info</b></h5>
    <div class="mb-3">
        <download-link-input link="{{ $app->installer->download_link }}" />
    </div>

    <div class="mb-3">
        <label for="launchArgsInput">Launch arguments</label>
        <input type="text" class="form-control" id="launchArgsInput" name="launchArgs" 
            value="{{ isset($app->installer) ? $app->installer->launch_args : '' }}" required />
    </div>

    <input type="hidden" name="id" value="{{ isset($_GET["id"]) ? $_GET["id"] : '' }}" />
    <input class="btn btn-primary" type="submit" value="Save" />
</form>