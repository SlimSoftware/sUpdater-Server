<?php

namespace App\Console\Commands;

use App\Models\App;
use App\Models\DetectInfo;
use App\Models\Installer;
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
                $this->info($app->version);

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
                $valueArray = [
                    'download_link' => $app->dl,
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
        } else {
            $this->error('Import file not found!');
        }

        return Command::SUCCESS;
    }
}
