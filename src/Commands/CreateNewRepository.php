<?php

namespace ThallesTeodoro\Repositories\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateNewRepository extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:create {name} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/new-repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\Repositories";
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        $model = str_replace("/", "\\", $this->argument('model'));
        $stub = $this->replaceModel($stub, $model);

        return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
    }

    private function replaceModel($stub, $model)
    {
        return str_replace(['{{ model }}', '{{model}}'], $model, $stub);
    }
}
