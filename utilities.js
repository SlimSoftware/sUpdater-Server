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
    return txt.replaceAll(versionVariable, version);
}

function replaceDotlessVariable(txt, version) {
    return txt.replaceAll(dotlessVariable, convertToDotlessVersion(version));
}

function replaceMajorMinorVariable(txt, version) {
    return txt.replaceAll(majorMinorVariable, convertToMajorMinorVersion(version));
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

function parseDL(dl, version) {
    let parsedDL = dl;
    
    if (containsVersionVariable(parsedDL)) {
        parsedDL = replaceVersionVariable(parsedDL, version);
    }
    if (containsDotlessVariable(parsedDL)) {
        parsedDL = replaceDotlessVariable(parsedDL, version);
    }
    if (containsMajorMinorVariable(parsedDL)) {
        parsedDL = replaceMajorMinorVariable(parsedDL, version);
    }

    return parsedDL;
}

function openDL() {
    let dl = document.querySelector('#dlInput').value;
    let version = document.querySelector('#versionInput').value;
    let parsedDL = parseDL(dl, version);

    window.open(parsedDL, "_blank");  
}