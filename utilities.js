function convertToDotlessVersion(version) {
    return version.replace(".", "");
}

function convertToMajorMinorVersion(version)
{
    let numbers = version.split(".", 3);
    let major = numbers[0];
    let minor = numbers[1];
    return `${major}.${minor}`;
}

function openDL() {
    let dl = document.querySelector('#dlInput').value;
    let version = document.querySelector('#versionInput').value;

    if (dl.includes("%ver%")) {
        dl = dl.replace("%ver%", version);
    }
    if (dl.includes("%verDotless%")) {
        dl = dl.replace("%verDotless%", convertToDotlessVersion(version));
    }
    if (dl.includes("%verMajorMinor%")) {
        dl = dl.replace("%verMajorMinor%", convertToMajorMinorVersion(version));
    }

    window.open(dl, "_blank");  
}