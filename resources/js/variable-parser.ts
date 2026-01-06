const VARIABLE_INDICATOR = '%';

/**
 * Replaces the given variables with their values in the given text
 * @param text The unparsed text to replace the variables in
 * @param variables The variables to replace
 * @returns The parsed text
 */
export function parseText(text: string, variables: object) {
    if (containsVariables(text, variables)) {
        for (const [variableName, variableValue] of Object.entries(variables)) {
            const toReplaceVariable = `${VARIABLE_INDICATOR}${variableName}${VARIABLE_INDICATOR}`;

            if (text.includes(toReplaceVariable)) {
                text = text.replaceAll(toReplaceVariable, variableValue);
            }
        }
    }

    return text;
}

/**
 * Checks whether the given text contains any of the given variables
 * @param text The text to check for variables
 * @param variables The variables to check for
 * @returns True or false according to whether the given text contains variables or not
 */
export function containsVariables(text: string, variables: object): boolean {
    for (const variableName of Object.keys(variables)) {
        const toReplaceVariable = `${VARIABLE_INDICATOR}${variableName}${VARIABLE_INDICATOR}`;

        if (text.includes(toReplaceVariable)) {
            return true;
        }
    }

    return false;
}

function splitVersion(version: string, digits: number) {
    const numbers = version.split('.', digits);
    return numbers.join('.');
}

export type VariablesMap = { [key: string]: string };

/** Returns a map object with the variable name as the key and the parsed variable value as the value */
export function getVariablesMap(version?: string | null): VariablesMap {
    if (!version) return {};

    return {
        ver: version ? version : '',
        'ver.0': version ? version.replaceAll('.', '') : '',
        'ver.1': version ? splitVersion(version, 2) : '',
        'ver.2': version ? splitVersion(version, 3) : '',
        'ver.3': version ? splitVersion(version, 4) : ''
    };
}

export function getParsedValue(unparsedValue: string | undefined, variablesMap: VariablesMap) {
    if (!unparsedValue) return '';

    return parseText(unparsedValue, variablesMap);
}
