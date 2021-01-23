<?php


namespace Spatie\LaravelPackageTools;

use Illuminate\Support\ServiceProvider;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

abstract class PackageServiceProvider extends ServiceProvider
{
    protected Package $packageConfig;

    abstract public function configurePackage(Package $package): void;

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if ($configFileName = $this->packageConfig->configFileName) {
                $this->publishes([
                    __DIR__ . "/../config/{$configFileName}.php" => config_path("{$configFileName}.php"),
                ], "{$this->packageConfig->name}-config");
            }

            if ($this->packageConfig->hasViews) {
                $this->publishes([
                    __DIR__ . '/../resources/views' => base_path("resources/views/vendor/{$this->packageConfig->name}"),
                ], "{$this->packageConfig->name}-views");
            }

            foreach ($this->packageConfig->migrationFileNames as $migrationFileName) {
                if (! $this->migrationFileExists($migrationFileName)) {
                    $this->publishes([
                        __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                    ], "{$this->packageConfig->name}-migrations");
                }
            }

            $this->commands($this->packageConfig->commands);
        }

        if ($this->packageConfig->hasViews) {
            $this->loadViewsFrom(__DIR__ . '/../resources/views', $this->packageConfig->name);
        }
    }

    public function register()
    {
        $this->packageConfig = new Package();

        $this->configurePackage($this->packageConfig);

        if (empty($this->packageConfig->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        if ($configFileName = $this->packageConfig->configFileName) {
            $this->mergeConfigFrom(__DIR__ . '/../config/skeleton.php', $configFileName);
        }
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);

        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}
