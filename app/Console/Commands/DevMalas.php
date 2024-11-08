<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DevMalas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:lazy {name : Class (singular) for example User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Let\'s be a smart and lazy developer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->controller($name);
        $this->model($name);
        $this->request($name);
    
        $this->line('Writing resource routes');

        File::append(base_path('routes/web.php'), "Route::resource('" . Str::plural(strtolower($name)) . "', App\\Http\\Controllers\\{$name}Controller::class);\n");

        $this->info('Resource route registered successfully!');

        return Command::SUCCESS;
    }

    /**
     * Get stub contents of the resource.
     *
     * @param string $type
     * @return string
     */
    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    /**
     * Write controller to Controllers folder.
     *
     * @param string $name
     * @return string
     */
    protected function controller($name)
    {
        $filePath = app_path("/Http/Controllers/{$name}Controller.php");
        
        $this->line('Creating new controller file');
        $this->line('Path: ' . $filePath);

        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );
    
        if (file_exists($filePath)) {
            $this->error('File already exists!');
        } else {
            file_put_contents($filePath, $controllerTemplate);
            $this->info('File created successfully!');
        }
        $this->newLine();
    }

    /**
     * Write model to Models folder.
     *
     * @param string $name
     * @return string
     */
    protected function model($name)
    {
        $filePath = app_path("/Models/{$name}.php");

        $this->line('Creating new model file');
        $this->line('Path: ' . $filePath);

        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
    
        if (file_exists($filePath)) {
            $this->error('File already exists!');
        } else {
            file_put_contents($filePath, $modelTemplate);
            $this->info('File created successfully!');
        }
        $this->newLine();
    }

    /**
     * Write form request to Request folder.
     *
     * @param string $name
     * @return string
     */
    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );
    
        if (!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);
    
        $filePath = app_path("/Http/Requests/{$name}Request.php");

        $this->line('Creating form request file');
        $this->line('Path: ' . $filePath);

        if (file_exists($filePath)) {
            $this->error('File already exists!');
        } else {
            file_put_contents($filePath, $requestTemplate);
            $this->info('File created successfully!');
        }
        $this->newLine();
    }
}
