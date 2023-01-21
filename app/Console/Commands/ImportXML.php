<?php

namespace App\Console\Commands;

use App\Models\App;
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
                $existingApp = App::where('name', $app['name'])->first();
                $valueArray = [
                    'name' => $app['name'],
                    'version' => $app->version,
                    'noupdate' => $app->type === 'noupdate' ? 1 : 0
                ];

                if ($existingApp === null) {
                    $this->info("Creating app {$app['name']}");
                    App::create($valueArray);
                } else {
                    $this->info("Updating app {$app['name']}");
                    $existingApp->update($valueArray);
                }
            }
        } else {
            $this->error('Import file not found!');
        }

        return Command::SUCCESS;
    }
}
