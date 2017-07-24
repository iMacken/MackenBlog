<?php

namespace App\Commands;

use Barryvdh\Debugbar\ServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use App\Traits\Seedable;
use App\Providers\AdminServiceProvider;

class InstallCommand extends Command
{
    use Seedable;

    protected $seedersPath = __DIR__.'/../../database/seeds/';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Admin Admin package';

    protected function getOptions()
    {
        return [
            ['with-dummy', null, InputOption::VALUE_NONE, 'Install with dummy data', null],
        ];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function fire(Filesystem $filesystem)
    {
        if (!$filesystem->exists(base_path('.env'))) {
            $filesystem->copy(base_path('.env.example'), base_path('.env'));
        }

        $this->info('Generating app key');
        $this->call('key:generate');

        $this->info('Publishing some files...');
        $this->call('vendor:publish', ['--provider' => ServiceProvider::class]);

        $this->info('Migrating the database tables into your application');
        $this->call('migrate');

        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer.' dump-autoload');
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Seeding data into the database');
        $this->seed('DatabaseSeeder');

        if (!$filesystem->exists(public_path('storage'))) {
            $this->info('Adding the storage symlink to your public folder');
            $this->call('storage:link');
        }

        $this->info('Successfully installed App! Enjoy 🎉');
    }
}
