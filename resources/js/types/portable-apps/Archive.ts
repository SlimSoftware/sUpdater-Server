import { Arch } from '../../enums/Arch';
import { ExtractMode } from '../../enums/ExtractMode';

export default interface Archive {
    id: number;
    portable_app_id: number;
    arch: Arch;
    download_link: string;
    download_link_raw: string;
    extract_mode: ExtractMode;
    launch_file: string;
}
