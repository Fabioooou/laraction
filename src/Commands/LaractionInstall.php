<?php

namespace Laraction\Commands;

use Illuminate\Console\Command;

class LaractionInstall extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'laraction:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laraction';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Installing Laraction...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => "Laraction\App\Providers\LaractionProvider",
            '--tag' => "config"
        ]);

        $this->info('Publishing stubs...');

        $this->call('vendor:publish', [
            '--provider' => "Laraction\App\Providers\LaractionProvider",
            '--tag' => "stubs"
        ]);

        $this->info('Installed Laraction !');
    }

}