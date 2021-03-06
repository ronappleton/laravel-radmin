<?php

namespace RonAppleton\Radmin;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use RonAppleton\MenuBuilder\Traits\AddsMenu;
use RonAppleton\Radmin\Console\Commands\RadminUser;
use RonAppleton\Radmin\Http\Middleware\RadminAthenticate;
use Spatie\Permission\Middlewares\RoleMiddleware;
use RonAppleton\Radmin\Exceptions\RadminHandler;

class ModuleServiceProvider extends ServiceProvider
{
    use AddsMenu;
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'RonAppleton\Radmin\Http\Controllers';


    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);
        $this->app = $app;
    }

    public function boot(Dispatcher $events)
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RadminUser::class,
            ]);
        }

        app('router')->aliasMiddleware('role', RoleMiddleware::class);
        app('router')->aliasMiddleware('radmin', RadminAthenticate::class);

        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViews();
        $this->publishConfig();
        $this->publishAssets();
        $this->menuListener($events);
    }

    public function register()
    {
        $this->extendExceptionHandler();
    }

    private function extendExceptionHandler()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            RadminHandler::class
        );
    }

    private function loadViews()
    {
        $viewsPath = $this->packagePath('resources/views');

        $this->loadViewsFrom($viewsPath, 'radmin');

        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/radmin'),
        ], 'views');
    }

    private function publishConfig()
    {
        $configPath = $this->packagePath('config/radmin.php');

        $this->publishes([
            $configPath => config_path('radmin.php'),
        ], 'config');

        $this->mergeConfigFrom($configPath, 'radmin');
    }

    private function publishAssets()
    {
        $this->publishes([
            $this->packagePath('/public/vendor') => public_path('/vendor'),
        ]);
    }

    private function packagePath($path)
    {
        return __DIR__ . "/../$path";
    }

    protected function loadViewsFrom($path, $namespace)
    {
        if (is_array($this->app->config['view']['paths'])) {
            foreach ($this->app->config['view']['paths'] as $viewPath) {
                if (is_dir($appPath = $viewPath . '/vendor/' . $namespace)) {
                    $this->app['view']->addNamespace($namespace, $appPath);
                }
            }
        }

        $this->app['view']->addNamespace($namespace, $path);
    }

    public function menuNavbar()
    {
        return [
            [
                'text' => 'Woohoo',
                'url' => '#',
                'icon' => 'cart',
                'submenu' => [
                    [
                        'text' => 'Dynamic Called',
                        'text_color' => 'primary',
                        'url' => 'product',
                        'icon' => 'list',
                        'dropped',
                    ],
                    [
                        'text' => 'Product Category',
                        'url' => 'product_category',
                        'icon' => 'motorcycle',
                        'dropped',
                    ],
                ],
            ],
        ];
    }
}