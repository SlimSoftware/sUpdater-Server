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