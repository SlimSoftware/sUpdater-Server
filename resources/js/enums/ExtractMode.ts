export enum ExtractMode {
    Folder,
    Single
}

export const extractModeNames = Object.keys(ExtractMode).filter(([key]) => isNaN(Number(key)));
