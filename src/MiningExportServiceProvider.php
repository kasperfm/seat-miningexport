<?php

namespace KasperFM\Seat\MiningExport;

use Illuminate\Routing\Router;
use Seat\Services\AbstractSeatPlugin;
use Seat\Web\Http\Middleware\Locale;

/**
 * Class MiningExportServiceProvider
 * @package KasperFM\Seat\MiningExport
 */
class MiningExportServiceProvider extends AbstractSeatPlugin
{
    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        // Include the Routes
        $this->add_routes();

        // Add the views for MiningExport
        $this->add_views();
    }

    public function register()
    {
        // Merge the config with anything in the main app
        // Web package configurations
        $this->mergeConfigFrom(
            __DIR__ . '/Config/miningexport.config.php', 'miningexport.config');

        $this->registerPermissions(
            __DIR__ . '/Config/miningexport.permissions.php', 'miningexport');

        // Menu Configurations
        $this->mergeConfigFrom(
            __DIR__ . '/Config/miningexport.sidebar.php', 'package.sidebar');

    }

    /**
     * Include the routes
     */
    public function add_routes()
    {
        if (!$this->app->routesAreCached())
            include __DIR__ . '/Routes/web.php';
    }

    /**
     * Set the path and namespace for the views
     */
    public function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'miningexport');
    }

    public function getName(): string
    {
        return 'Seat-MiningExport';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/kasperfm/seat-miningexport';
    }

    public function getPackagistPackageName(): string
    {
        return 'seat-miningexport';
    }

    public function getPackagistVendorName(): string
    {
        return 'kasperfm';
    }

    public function getVersion(): string
    {
        return config('miningexport.config.version');
    }
}