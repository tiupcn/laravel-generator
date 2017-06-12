<?php

namespace InfyOm\Generator\Generators\AngularJs;

use InfyOm\Generator\Common\CommandData;
use InfyOm\Generator\Generators\BaseGenerator;
use InfyOm\Generator\Utils\FileUtil;
use InfyOm\Generator\Utils\GeneratorFieldsInputUtil;

class ViewGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    private $pagePath;
    /** @var string */
    private $templateType;

    /** @var array */
    private $htmlFields;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->path = base_path('resources/assets/app/');
        $this->pagePath = base_path('resources/assets/app/pages/'.$commandData->config->mCamelPlural.'/');
    }

    public function generate()
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }

        $this->commandData->commandComment("\nGenerating Views...");
        $this->generateIndex();
        $this->generateRoute();
        //edit or create
        $this->generateForm();

        //empty css file
        FileUtil::createFile($this->pagePath, 'style.css', '');
        $this->commandData->commandComment('Views created: ');
    }

    public function generateRoute(){
        $filename = $this->path."config.route.js";
        $modelRouteData = get_template('angularjs.page.route', 'laravel-generator');
        $modelRouteData = fill_template($this->commandData->dynamicVars, $modelRouteData);
        
        $routeData = file_get_contents($filename);
        $routeData = str_replace("//generator end", $modelRouteData, $routeData);
        file_put_contents($filename, $routeData);
    }

    public function generateIndex(){
        $controllerData = get_template('angularjs.page.index_controller', 'laravel-generator');
        $controllerData = fill_template($this->commandData->dynamicVars, $controllerData);
        FileUtil::createFile($this->pagePath, 'index.js', $controllerData);

        $templateData = get_template('angularjs.page.index_tpl', 'laravel-generator');
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        FileUtil::createFile($this->pagePath, 'index.html', $templateData);
    }

    public function generateForm(){
        $controllerData = get_template('angularjs.page.edit_controller', 'laravel-generator');
        $controllerData = fill_template($this->commandData->dynamicVars, $controllerData);
        FileUtil::createFile($this->pagePath, 'edit.js', $controllerData);

        $templateData = get_template('angularjs.page.edit_tpl', 'laravel-generator');
        $templateData = fill_template($this->commandData->dynamicVars, $templateData);
        FileUtil::createFile($this->pagePath, 'edit.html', $templateData);
    }
}
