<?php

namespace InfyOm\Generator\Commands\AngularJs;

use InfyOm\Generator\Commands\BaseCommand;
use InfyOm\Generator\Common\CommandData;
use InfyOm\Generator\Generators\MigrationGenerator;
use InfyOm\Generator\Generators\ModelGenerator;
use InfyOm\Generator\Generators\RepositoryGenerator;
use InfyOm\Generator\Generators\Scaffold\MenuGenerator;
use InfyOm\Generator\Generators\AngularJs\APIRequestGenerator;
use InfyOm\Generator\Generators\AngularJs\ControllerGenerator;
use InfyOm\Generator\Generators\AngularJs\ModelJsConfigGenerator;
use InfyOm\Generator\Generators\AngularJs\RoutesGenerator;
use InfyOm\Generator\Generators\AngularJs\ViewGenerator;

use InfyOm\Generator\Generators\API\APITestGenerator;
use InfyOm\Generator\Generators\TestTraitGenerator;
use InfyOm\Generator\Generators\RepositoryTestGenerator;

class AngularJsGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'infyom:angularjs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full CRUD views and config using AngularJS Framework for given model';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_VUEJS);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        parent::handle();

        if (!$this->commandData->getOption('fromTable')) {
            $migrationGenerator = new MigrationGenerator($this->commandData);
            $migrationGenerator->generate();
        }

        $modelGenerator = new ModelGenerator($this->commandData);
        $modelGenerator->generate();

        $repositoryGenerator = new RepositoryGenerator($this->commandData);
        $repositoryGenerator->generate();

        $requestGenerator = new APIRequestGenerator($this->commandData);
        $requestGenerator->generate();

        $controllerGenerator = new ControllerGenerator($this->commandData);
        $controllerGenerator->generate();

        $viewGenerator = new ViewGenerator($this->commandData);
        $viewGenerator->generate();

        $routeGenerator = new RoutesGenerator($this->commandData);
        $routeGenerator->generate();

        if (!$this->isSkip('tests') and $this->commandData->getAddOn('tests')) {
            $repositoryTestGenerator = new RepositoryTestGenerator($this->commandData);
            $repositoryTestGenerator->generate();

            $testTraitGenerator = new TestTraitGenerator($this->commandData);
            $testTraitGenerator->generate();

            $apiTestGenerator = new APITestGenerator($this->commandData);
            $apiTestGenerator->generate();
        }


        // if ($this->commandData->config->getAddOn('menu.enabled')) {
        //     $menuGenerator = new MenuGenerator($this->commandData);
        //     $menuGenerator->generate();
        // }

        $this->performPostActionsWithMigration();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }
}
