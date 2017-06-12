<?php

namespace InfyOm\Generator\Commands\Publish;

use InfyOm\Generator\Utils\FileUtil;

class AngularJsLayoutPublishCommand extends PublishBaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'infyom.publish:angularjs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish custom files and directories for AngularJS Crud Version';

    /**
     * Laravel Application version.
     *
     * @var string
     */
    protected $laravelVersion;

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $this->copyView();
        $this->updateRoutes();
        $this->publishHomeController();
        $this->publishApiController();
    }

    private function copyView()
    {
        //copy js
        $path = base_path('resources/assets/app/');

        //初始化公共组件
        $appJsTemplate = get_template('angularjs.js.app', 'laravel-generator');
        FileUtil::createFile($path, 'app.js', $appJsTemplate);

        $lazyLoadTemplate = get_template('angularjs.js.lazyload', 'laravel-generator');
        FileUtil::createFile($path, 'config.lazyload.js', $lazyLoadTemplate);

        $routeTemplate = get_template('angularjs.js.route', 'laravel-generator');
        FileUtil::createFile($path, 'config.route.js', $routeTemplate);

        $libsTemplate = get_template('angularjs.js.libs', 'laravel-generator');
        FileUtil::createFile($path, 'libs.js', $libsTemplate);

        //初始化首页
        $path = base_path('resources/assets/app/');

        $homeTemplate = get_template('angularjs.index.home','laravel-generator');
        FileUtil::createFile('resources/views/','home.blade.php', $homeTemplate);
        $pagesPath = base_path('resources/assets/app/pages/index/');
        $controllerTemplate = get_template('angularjs.index.controller', 'laravel-generator');
        FileUtil::createFile($pagesPath, 'index.js', $controllerTemplate);

        $controllerTemplate = get_template('angularjs.index.tpl', 'laravel-generator');
        FileUtil::createFile($pagesPath, 'tpl.html', $controllerTemplate);
    }


    private function updateRoutes()
    {
        $path = config('infyom.laravel_generator.path.routes', app_path('Http/routes.php'));
        $routeContents = file_get_contents($path);
        $routesTemplate = get_template('angularjs.routes.auth', 'laravel-generator');
        $routeContents .= "\n\n".$routesTemplate;
        file_put_contents($path, $routeContents);
        $this->comment("\nRoutes added");
    }

    private function publishApiController(){
        $templateData = get_template('angularjs.controller.api_base_controller', 'laravel-generator');
        $templateData = $this->fillTemplate($templateData);
        $fileName = 'ApiController.php';
        $controllerPath = config('infyom.laravel_generator.path.controller', app_path('Http/Controllers/'));
        if (file_exists($controllerPath.$fileName)) {
            $answer = $this->ask('Do you want to overwrite '.$fileName.'? (y|N) :', false);

            if (strtolower($answer) != 'y' and strtolower($answer) != 'yes') {
                return;
            }
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('ApiController created');
    }

    private function publishHomeController()
    {
        $templateData = get_template('home_controller', 'laravel-generator');

        $templateData = $this->fillTemplate($templateData);

        $controllerPath = config('infyom.laravel_generator.path.controller', app_path('Http/Controllers/'));

        $fileName = 'HomeController.php';

        if (file_exists($controllerPath.$fileName)) {
            $answer = $this->ask('Do you want to overwrite '.$fileName.'? (y|N) :', false);

            if (strtolower($answer) != 'y' and strtolower($answer) != 'yes') {
                return;
            }
        }

        FileUtil::createFile($controllerPath, $fileName, $templateData);

        $this->info('HomeController created');
    }

    /**
     * Replaces dynamic variables of template.
     *
     * @param string $templateData
     *
     * @return string
     */
    private function fillTemplate($templateData)
    {
        $templateData = str_replace(
            '$NAMESPACE_CONTROLLER$',
            config('infyom.laravel_generator.namespace.controller'), $templateData
        );

        $templateData = str_replace(
            '$NAMESPACE_REQUEST$',
            config('infyom.laravel_generator.namespace.request'), $templateData
        );

        return $templateData;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return [];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }
}
