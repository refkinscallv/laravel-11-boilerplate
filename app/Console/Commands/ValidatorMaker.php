<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ValidatorMaker extends Command
{
    protected $signature = 'make:validator {name}';
    protected $description = 'Generate a validator class';

    public function handle()
    {
        $rawName = $this->argument('name');
        $className = Str::studly($rawName);
        $fileName = "{$className}.php";
        $namespace = 'App\Http\Validators';
        $path = app_path('Http/Validators');
        $fullPath = "{$path}/{$fileName}";

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        if (file_exists($fullPath)) {
            $this->components->error("Validator [{$namespace}\\{$className}] already exists.");
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
        $this->components->info("Validator [{$namespace}\\{$className}] created successfully.");
    }
}
