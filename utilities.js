let versionVariable = "%ver%";
let dotlessVariable = "%verDotless%";
let majorMinorVariable = "%verMajorMinor%";

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

function replaceVersionVariable(txt, version) {
    return txt.replace(versionVariable, version);
}

function replaceDotlessVariable(txt, version) {
    return txt.replace(dotlessVariable, convertToDotlessVersion(version));
}

function replaceMajorMinorVariable(txt, version) {
    return txt.replace(majorMinorVariable, convertToMajorMinorVersion(version));
}

function containsVersionVariable(txt) {
    return txt.includes(versionVariable);
}

function containsDotlessVariable(txt) {
    return txt.includes(dotlessVariable);
}

function containsMajorMinorVariable(txt) {
    return txt.includes(majorMinorVariable);
}

function openDL() {
    let dl = document.querySelector('#dlInput').value;
    let version = document.querySelector('#versionInput').value;

    if (containsVersionVariable(dl)) {
        dl = replaceVersionVariable(dl, version);
    }
    if (containsDotlessVariable(dl)) {
        dl = replaceDotlessVariable(dl, version);
    }
    if (containsMajorMinorVariable(dl)) {
        dl = replaceMajorMinorVariable(dl, version);
    }

    window.open(dl, "_blank");  
}