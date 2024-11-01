<?php

namespace VendorName\SetupPackage\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupProject extends Command
{
    protected $signature = 'project:setup';
    protected $description = 'Set up the Laravel project with necessary configurations';

    public function handle()
    {
        $this->info('Setting up the project...');

        // Publier le fichier de configuration
        Artisan::call('vendor:publish', ['--tag' => 'setup-package-config']);

        // Installer les dépendances
        $this->runComposerInstall();

        // Générer une clé d'application
        Artisan::call('key:generate');

        // Exécuter les migrations
        Artisan::call('migrate', ['--seed' => true]);

        // Optimiser l'application
        Artisan::call('optimize');

        $this->info('Project setup completed successfully!');
    }

    protected function runComposerInstall()
    {
        exec('composer install', $output, $return_var);
        if ($return_var !== 0) {
            $this->error('Failed to run composer install: ' . implode("\n", $output));
        } else {
            $this->info('Composer dependencies installed.');
        }
    }
}
