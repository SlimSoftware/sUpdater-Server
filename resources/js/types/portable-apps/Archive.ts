export default interface Archive {
    id: number;
    name: string;
    version: string | null;
    noupdate: boolean;
    release_notes_url: string;
    website_url: string;
    archives: Array<Archive>;
    installers: Array<Installer>;
    created_at: string;
    updated_at: string;
}
