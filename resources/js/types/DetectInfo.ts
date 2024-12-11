export default interface DetectInfo {
    id: number;
    app_id: number;
    arch: number;
    installer: Installer;
    reg_key: string;
    reg_value: string;
    exe_path: string;
}
