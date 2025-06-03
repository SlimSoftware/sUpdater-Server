export function isValidUrl(url?: string) {
    if (!url) return false;

    try {
        new URL(url);
        return true;
    } catch (_) {
        return false;
    }
}
