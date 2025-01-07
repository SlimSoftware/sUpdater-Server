import { Arch } from '../../enums/Arch';
import Archive from './Archive';

export default interface PortableApp {
    id: number;
    name: string;
    version: string | null;
    arch: Arch;
    release_notes_url: string;
    website_url: string;
    archives: Array<Archive>;
    created_at: string;
    updated_at: string;
}
