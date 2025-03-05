import Archive from './Archive';

export default interface PortableApp {
    id: number;
    name: string;
    version?: string;
    release_notes_url: string;
    website_url: string;
    archives: Array<Archive>;
    created_at: string;
    updated_at: string;
}
