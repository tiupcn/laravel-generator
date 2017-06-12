<?php

namespace InfyOm\Generator\Generators\AngularJs;

use Illuminate\Support\Str;
use InfyOm\Generator\Common\CommandData;
use InfyOm\Generator\Generators\BaseGenerator;

class RoutesGenerator extends BaseGenerator
{
    /** @var CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $pathApi;

    /** @var string */
    private $apiRouteContents;

    /** @var string */
    private $apiRoutesTemplate;

    public function __construct(CommandData $commandData)
    {
        $this->commandData = $commandData;
        $this->pathApi = $commandData->config->pathApiRoutes;
        $this->path = $commandData->config->pathRoutes;

        $this->routeContents = file_get_contents($this->path);
        
        if (!file_exists($this->pathApi)) {
            file_put_contents($this->pathApi, get_template('angularjs.routes.api_routes', 'laravel-generator'));
        }

        $this->apiRouteContents = file_get_contents($this->pathApi);

        $apiRoutesTemplate = get_template('angularjs.routes.api', 'laravel-generator');
        $this->apiRoutesTemplate = fill_template($this->commandData->dynamicVars, $apiRoutesTemplate);
    }

    public function generate()
    {
        $this->apiRouteContents .= "\n\n".$this->apiRoutesTemplate;
        file_put_contents($this->pathApi, $this->apiRouteContents);

        $this->commandData->commandComment("\n".$this->commandData->config->mCamelPlural.' routes added.');
    }

    public function rollback()
    {
        if (Str::contains($this->routeContents, $this->routesTemplate)) {
            $this->routeContents = str_replace($this->routesTemplate, '', $this->routeContents);
            file_put_contents($this->path, $this->routeContents);
            $this->commandData->commandComment('angularjs routes deleted');
        }

        if (Str::contains($this->apiRouteContents, $this->apiRoutesTemplate)) {
            $this->apiRouteContents = str_replace($this->apiRoutesTemplate, '', $this->apiRouteContents);
            file_put_contents($this->pathApi, $this->apiRouteContents);
            $this->commandData->commandComment('angularjs api routes deleted');
        }
    }
}
