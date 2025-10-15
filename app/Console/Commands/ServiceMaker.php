<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ServiceMaker extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Generate a service class';

    public function handle()
    {
        $rawName = $this->argument('name');
        $className = Str::studly($rawName);
        $fileName = "{$className}.php";
        $namespace = 'App\Services';
        $path = app_path('Services');
        $fullPath = "{$path}/{$fileName}";

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        if (file_exists($fullPath)) {
            $this->components->error("Service [{$namespace}\\{$className}] already exists.");
            return;
        }

        $stub = <<<PHP
<?php

namespace {$namespace};

use Illuminate\Http\Request;

class {$className} extends Base
{
    //
}

PHP;

        file_put_contents($fullPath, $stub);
        $this->components->info("Service [{$namespace}\\{$className}] created successfully.");
    }
}
