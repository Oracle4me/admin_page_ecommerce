<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create HMVC module structure';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $snake = Str::snake($name);
        $basePath = app_path("Modules/{$name}");

        // Folder HMVC
        $folders = [
            'Controllers/Api',
            'Controllers/Web',
            'Models',
            'Requests',
            'Resources',
            'Repositories',
            'Services',
            'Routes',
        ];

        foreach ($folders as $folder) {
            app('files')->makeDirectory("{$basePath}/{$folder}", 0755, true, true);
        }

        $this->generateFiles($name, $snake, $basePath);

        $this->info("Module {$name} berhasil dibuat");
    }

    protected function generateFiles(string $name, string $snake, string $basePath)
    {
        // API Controller
        $this->stub('api-controller', "{$basePath}/Controllers/Api/{$name}Controller.php", [
            'namespace' => "App\\Modules\\{$name}\\Controllers\\Api",
            'class'     => "{$name}Controller",
            'module'    => $name,
        ]);

        // Web Controller
        $this->stub('web-controller', "{$basePath}/Controllers/Web/{$name}ViewController.php", [
            'namespace' => "App\\Modules\\{$name}\\Controllers\\Web",
            'class'     => "{$name}ViewController",
            'view'      => "admin.{$snake}",
        ]);

        // Model
        $this->stub('model', "{$basePath}/Models/{$name}.php", [
            'namespace' => "App\\Modules\\{$name}\\Models",
            'class'     => $name,
            'table'     => Str::plural($snake),
        ]);

        // Request
        $this->stub('request', "{$basePath}/Requests/{$name}Request.php", [
            'namespace' => "App\\Modules\\{$name}\\Requests",
            'class'     => "{$name}Request",
        ]);

        // Resource
        $this->stub('resource', "{$basePath}/Resources/{$name}Resource.php", [
            'namespace' => "App\\Modules\\{$name}\\Resources",
            'class'     => "{$name}Resource",
        ]);

        // Repository
        $this->stub('repository', "{$basePath}/Repositories/{$name}Repository.php", [
            'namespace' => "App\\Modules\\{$name}\\Repositories",
            'class'     => "{$name}Repository",
            'module'    => $name,
        ]);

        // Service
        $this->stub('service', "{$basePath}/Services/{$name}Service.php", [
            'namespace' => "App\\Modules\\{$name}\\Services",
            'class'     => "{$name}Service",
            'module'    => $name,
        ]);

        // API Route
        $this->stub('api', "{$basePath}/Routes/api.php", [
            'module' => $name,
            'route'  => $snake,
        ]);

        // Web Route
        $this->stub('web', "{$basePath}/Routes/web.php", [
            'module' => $name,
            'route'  => $snake,
        ]);
    }

    protected function stub(string $stubName, string $targetPath, array $replacements = [])
    {
        $stubPath = base_path("stubs/hmvc/{$stubName}.stub");

        if (!file_exists($stubPath)) {
            $this->error("TemplateStub {$stubName}.stub tidak ditemukan");
            return;
        }

        $content = file_get_contents($stubPath);

        foreach ($replacements as $key => $value) {
            $content = str_replace('{{ ' . $key . ' }}', $value, $content);
        }

        app('files')->put($targetPath, $content);
    }
}
