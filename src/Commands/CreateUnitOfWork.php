<?php

namespace ThallesTeodoro\Repositories\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateUnitOfWork extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unit-of-work:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Unit Of Work Repository';

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
        return __DIR__ . '/stubs/unit-of-work.stub';
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
}
