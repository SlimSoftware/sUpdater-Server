interface App {
    id: number,
    name: string,
    version: string,
    noupdate: boolean,
    release_notes_url: string,
    website_url: string,
    detectinfo: Array<DetectInfo>,
    installers: Array<Installer>,
    created_at: string,
    updated_at: string
}