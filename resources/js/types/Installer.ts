export default interface Installer {
    id: number;
    app_id: number;
    arch: number;
    detectinfo_id: number;
    download_link: string;
    download_link_raw: string;
    launch_args: string;
}
