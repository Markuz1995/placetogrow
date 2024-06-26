<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CreateDomainStructure extends Command
{
    protected $signature = 'make:domain {name : The name of the domain}';
    protected $description = 'Create a new domain structure';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $basePath = app_path('Domains/' . $name);

        $directories = [
            $basePath,
            $basePath . '/Models',
            $basePath . '/Repositories',
            $basePath . '/Services',
        ];

        foreach ($directories as $directory) {
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Created: $directory");
            } else {
                $this->warn("Directory already exists: $directory");
            }
        }

        $this->info("Domain structure for '$name' created successfully.");
    }
}
