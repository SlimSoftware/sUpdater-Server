<?php

namespace App\Console\Commands;

use App\Models\App;
use App\Models\Archive;
use App\Models\DetectInfo;
use App\Models\Installer;
use App\Models\PortableApp;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportXML extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from the legacy xml format';

    const FILE_PATH = 'import.xml';
    const ARCHS = ['*', 'x86', 'x64'];
    const EXTRACT_MODES = ['single', 'folder'];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (Storage::disk('local')->exists(self::FILE_PATH)) {
            $xmlPath = storage_path('app/' . self::FILE_PATH);
            $this->info("Import file found at $xmlPath");

            $xml = simplexml_load_file($xmlPath);

            foreach ($xml->app as $app) {
                $appName = $app['name'];
                $existingApp = App::where('name', $appName)->first();
                $valueArray = [
                    'name' => $appName,
                    'version' => $app->version == '(latest)' ? null : $app->version,
                    'noupdate' => $app->type == 'noupdate' ? true : false,
                ];

                if ($existingApp === null) {
                    $this->info("Creating app $appName");
                    $existingApp = App::create($valueArray);
                } else {
                    $this->info("Updating app $appName");
                    $existingApp->update($valueArray);
                }

                $archIndex = array_search($app->arch, self::ARCHS);
                $existingDetectInfo = $existingApp->has('detectInfo')
                    ? $existingApp->detectInfo->firstWhere('arch', $archIndex)
                    : null;
                $valueArray = [
                    'arch' => $archIndex,
                    'reg_key' => $app->regkey,
                    'reg_value' => $app->regvalue,
                    'exe_path' => $app->exePath,
                ];

                $savedDetectInfo = null;
                if ($existingDetectInfo === null) {
                    $this->info("Creating DetectInfo for $appName");
                    $detectInfo = new DetectInfo($valueArray);
                    $detectInfo->app()->associate($existingApp);
                    $detectInfo->save();
                    $savedDetectInfo = $detectInfo;
                } else {
                    $this->info("Updating DetectInfo for $appName ($app->arch)");
                    $existingDetectInfo->update($valueArray);
                    $savedDetectInfo = $existingDetectInfo;
                }

                $existingInstaller = $existingApp->has('installers') ? $existingApp->installers->first() : null;
                $dl = $app->dl;
                $dl = str_replace('%verDotless%', '%ver.0%', $dl);
                $dl = str_replace('%verMajorMinor%', '%ver.1%', $dl);

                $valueArray = [
                    'download_link' => $dl,
                    'launch_args' => $app->switch,
                ];

                if ($existingInstaller === null) {
                    $this->info("Creating installer for $appName");
                    $installer = new Installer($valueArray);
                    $installer->app()->associate($existingApp);
                    $installer->detectInfo()->associate($savedDetectInfo);
                    $installer->save();
                } else {
                    $this->info("Updating first installer for $appName");
                    $existingInstaller->update($valueArray);
                }

                $this->newLine();
            }

            foreach ($xml->portable as $portableApp) {
                $portableName = $portableApp['name'];
                $existingPortableApp = PortableApp::where('name', $portableName)->first();
                $extractModeIndex = array_search($portableApp->extractmode, self::EXTRACT_MODES);
                $valueArray = [
                    'name' => $portableName,
                    'version' => $portableApp->version == '(latest)' ? null : $portableApp->version,
                    'arch' => $archIndex,
                ];

                $existingArchive = null;
                if ($existingPortableApp === null) {
                    $this->info("Creating Portable App $portableName");
                    $savedPortableApp = PortableApp::create($valueArray);
                } else {
                    $this->info("Updating Portable App $portableName");
                    $existingApp->update($valueArray);

                    if ($existingPortableApp->has('archives')) {
                        $existingArchive = $existingPortableApp->archives->first();
                    }

                    $savedPortableApp = $existingPortableApp;
                }

                $dl = $portableApp->dl;
                $dl = str_replace('%verDotless%', '%ver.0%', $dl);
                $dl = str_replace('%verMajorMinor%', '%ver.1%', $dl);

                $valueArray = [
                    'download_link' => $dl,
                    'extract_mode' => $extractModeIndex,
                    'launch_file' => $portableApp->launch,
                ];

                if ($existingArchive === null) {
                    $this->info("Creating archive for $portableName");
                    $archive = new Archive($valueArray);
                    $archive->portableApp()->associate($savedPortableApp);
                    $archive->save();
                } else {
                    $this->info("Updating first archive for $portableName");
                    $existingArchive->update($valueArray);
                }

                $this->newLine();
            }
        } else {
            $this->error('Import file not found!');
        }

        return Command::SUCCESS;
    }
}
