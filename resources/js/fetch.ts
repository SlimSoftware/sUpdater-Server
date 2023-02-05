const API_BASE_URL = '/api/v2';

/**
 * Helper function to fecth JSON data from an API
 * @param url The URL to fetch from
 * @param API Whether the given URL is an endpoint of the API, if so automatically appends the API base URL
 */
export async function useFetch(url: string, method: string = 'GET', body: BodyInit | null = null, API: boolean = true) {
    let response, json, error = null;
    if (API) {
        url = `${API_BASE_URL}/${url}`;
    }

    try {
        response = await fetch(url, {
            method: method,
            body: body
        });
        json = await response.json();
    } catch (err) {
        if (err instanceof Error) {
            error = err;
        }
    }

    return { json, response, error };
}
