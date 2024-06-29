<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HexagonalStructure extends Command
{
    protected $signature = 'make:hexagonal {name : The name of the module}';

    protected $description = 'Create a new structure for the module';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $basePathDomain = app_path('Domains/'.$name);

        $directories = [
            $basePathDomain,
            "{$basePathDomain}/Models",
            "{$basePathDomain}/Repositories",
            "{$basePathDomain}/Services",
            "{$basePathDomain}/Models/{$name}.php",
            "{$basePathDomain}/Repositories/{$name}Repository.php",
            "{$basePathDomain}/Services/{$name}Service.php",
        ];

        $basePathInfrastructure = app_path('Infrastructure/');
        $directories = array_merge($directories, [
            $basePathInfrastructure,
            "{$basePathInfrastructure}/Persistence",
            "{$basePathInfrastructure}/Persistence/{$name}RepositoryEloquent.php",
            "{$basePathInfrastructure}/Repositories",
            "{$basePathInfrastructure}/Services",
        ]);

        foreach ($directories as $path) {
            if (Str::endsWith($path, '.php')) {
                if (! File::exists($path)) {
                    File::put($path, "<?php\n\nnamespace ".str_replace('/', '\\', str_replace(app_path(), 'App', dirname($path))).";\n\n");
                    $this->info("Created file: $path");
                } else {
                    $this->warn("File already exists: $path");
                }
            } else {
                if (! File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true);
                    $this->info("Created directory: $path");
                } else {
                    $this->warn("Directory already exists: $path");
                }
            }
        }

        $this->info("Module structure for '$name' created successfully.");
    }
}
