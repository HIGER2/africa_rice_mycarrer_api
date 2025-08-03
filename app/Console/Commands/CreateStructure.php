<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class CreateServiceStructure extends Command
{
    protected $signature = 'create:service {name}';
    protected $description = 'Create controller, service, repository, and interface for a given name';

    public function handle()
    {
        $name = Str::studly($this->argument('name')); // Exemple : "User" ou "Job"

        // 1. Controller
        $controllerName = "Api/{$name}Controller";
        Artisan::call('make:controller', ['name' => $controllerName]);
        $this->info("✅ Controller created: app/Http/Controllers/Api/{$name}Controller.php");

        // 2. Service
        $servicePath = app_path("Services/{$name}Service.php");
        if (!file_exists($servicePath)) {
            $this->makeDirectoryIfNotExists(dirname($servicePath));
            file_put_contents($servicePath, "<?php

namespace App\Services;

class {$name}Service
{
    //
}
");
            $this->info("✅ Service created: app/Services/{$name}Service.php");
        }

        // 3. Interface
        $interfacePath = app_path("Repositories/Interfaces/{$name}Interface.php");
        if (!file_exists($interfacePath)) {
            $this->makeDirectoryIfNotExists(dirname($interfacePath));
            file_put_contents($interfacePath, "<?php

namespace App\Repositories\Interfaces;

interface {$name}Interface
{
    //
}
");
            $this->info("✅ Interface created: app/Repositories/Interfaces/{$name}Interface.php");
        }

        // 4. Repository
        $repositoryPath = app_path("Repositories/{$name}Repository.php");
        if (!file_exists($repositoryPath)) {
            $this->makeDirectoryIfNotExists(dirname($repositoryPath));
            file_put_contents($repositoryPath, "<?php

namespace App\Repositories;

use App\Repositories\Interfaces\\{$name}Interface;

class {$name}Repository implements {$name}Interface
{
    //
}
");
            $this->info("✅ Repository created: app/Repositories/{$name}Repository.php");
        }

        $this->info('🎉 All files have been generated successfully.');
        return Command::SUCCESS;
    }

    protected function makeDirectoryIfNotExists($path)
    {
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
    }
}
