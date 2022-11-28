<form method="POST" class="mb-3">
    <h5><b>General</b></h5>
    <div class="mb-3 col-md-3">
        <label for="nameInput">Name</label>
        <input type="text" class="form-control" id="nameInput" name="appName" 
            value="{{ isset($portableApp->name) ? $portableApp->name : '' }}" required />
    </div>

    <div class="mb-3 col-md-3">
        <label for="versionInput">Version</label>
        <input type="text" class="form-control" id="versionInput" name="version" onchange="updateDLHint()" 
            value="<?= isset($portableApp["version"]) ? $portableApp["version"] : "" ?>" required /></p>
    </div>

    <div class="mb-3 col-md-2">
        <label for="archSelect">Arch</label>
        <select class="form-select" id="archSelect" name="arch">
            <option value="0" @selected(isset($portableApp) && $portableApp->arch === 0)>Any</option>
            <option value="1" @selected(isset($portableApp) && $portableApp->arch === 1)>32-bit</option>
            <option value="2" @selected(isset($portableApp) && $portableApp->arch === 2)>64-bit</option>
        </select>
    </div>
    
    <div class="frm-check mb-2">
        <input type="checkbox" id="noupdateCheckbox" name="noupdate" 
            class="form-check-input" @checked(isset($portableApp->noupdate) && $portableApp->noupdate) />
        <label for="noupdateCheckbox" class="form-check-label">Use this app's own updater to check for updates</label>
    </div>

    <div class="mb-3">
        <label for="releaseNotesInput">Release notes URL</label>
        <input type="text" class="form-control" id="releaseNotesInput" name="releaseNotesUrl" 
            value="{{ isset($portableApp->release_notes_url) ? $portableApp->release_notes_url : '' }}" />
    </div>

    <div class="mb-3">
        <label for="websiteInput">Website URL</label>
        <input type="text" class="form-control" id="websiteInput" name="websiteUrl" 
            value="{{ isset($portableApp->website_url) ? $portableApp->website_url : '' }}" />
    </div>

    <h5><b>Archive Info</b></h5>
    <div class="mb-3">
        <label for="dlInput">Download link</label>
        <div class="input-group">
            <input type="text" class="form-control" id="dlInput" name="dl" 
                value="{{ isset($portableApp->archive) ? $portableApp->archive->download_link : ''}}" />
            <a class="btn btn-primary">Test link</a>
        </div>
        <span id="dlParsedHintContainer" class="text-muted" style="display: none;">Preview: <span id="dlParsedHint"></span></span>
        <details>
            <summary>Available variables</summary>
            <p>%ver% = {{ isset($portableApp->version) ? $portableApp->version : '' }}<br/>
            %verMajorMinor% = {{ isset($portableApp->version) ? $portableApp->version : '' }}<br/>
            %verDotless% = {{ isset($portableApp->version) ? $portableApp->version : '' }}</p>
        </details>
    </div>

    <div class="mb-3 col-md-2">
        <label for="extractModeSelect">Arch</label>
        <select class="form-select" id="extractModeSelect" name="extract_mode">
            <option value="0" @selected(isset($portableApp) && $portableApp->archive->extract_mode === 0)>Folder</option>
            <option value="1" @selected(isset($portableApp) && $portableApp->archive->extract_mode === 1)>Single</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="launchFileInput">File to launch</label>
        <input type="text" class="form-control" id="launchFileInput" name="launchFile" 
            value="{{ isset($portableApp->archive) ? $portableApp->archive->launch_file : '' }}" required />
    </div>

    <input type="hidden" name="id" value="{{ isset($_GET["id"]) ? $_GET["id"] : '' }}" />
    <input class="btn btn-primary" type="submit" value="Save" />
</form>