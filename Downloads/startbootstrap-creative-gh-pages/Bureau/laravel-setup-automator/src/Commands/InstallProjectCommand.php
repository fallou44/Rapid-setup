<?php

// packages/vendorname/setup-package/src/Commands/InstallProjectCommand.php

namespace VendorName\SetupPackage\Commands;

use Illuminate\Console\Command;

class InstallProjectCommand extends Command
{
    protected $signature = 'project:setup {--force}';
    protected $description = 'Automatise les étapes d\'installation pour un projet Laravel';

    public function handle()
    {
        $this->info("Début du processus d'installation...");

        $this->generateEnvFile();
        $this->installDependencies();
        $this->generateAppKey();
        $this->runMigrationsAndSeeders();
        $this->optimizeApp();

        $this->info("Installation terminée avec succès !");
    }

    protected function generateEnvFile()
    {
        if (!file_exists(base_path('.env'))) {
            $this->info("Création du fichier .env...");
            copy(base_path('.env.example'), base_path('.env'));
        } else {
            $this->info("Le fichier .env existe déjà.");
        }
    }

    protected function installDependencies()
    {
        $this->info("Installation des dépendances via Composer...");
        exec('composer install');
        exec('composer update');
    }

    protected function generateAppKey()
    {
        $this->info("Génération de la clé de l'application...");
        $this->call('key:generate');
    }

    protected function runMigrationsAndSeeders()
    {
        $this->info("Exécution des migrations et seeders...");
        $this->call('migrate:fresh', ['--seed' => true]);
    }

    protected function optimizeApp()
    {
        $this->info("Optimisation de l'application...");
        $this->call('optimize');
    }
}
