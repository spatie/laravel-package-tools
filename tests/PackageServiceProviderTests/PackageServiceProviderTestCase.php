<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProvider;
use function Spatie\PestPluginTestTime\testTime;
use Symfony\Component\Finder\SplFileInfo;

abstract class PackageServiceProviderTestCase extends TestCase
{
    protected array $cleanPaths = [
        'app/Providers/',
        'app/Livewire/',
        'app/View/Components/vendor/',
        'config/',
        'database/migrations/',
        'lang/vendor/',
        'public/vendor/',
        'resources/views/livewire/',
        'resources/views/vendor/',
        'resources/js/Pages/',
        'storage/framework/views/',
    ];

    protected array $cleanExclusions = [
        'config/app.php',
        'config/auth.php',
        'config/broadcasting.php',
        'config/cache.php',
        'config/concurrency.php',
        'config/cors.php',
        'config/database.php',
        'config/filesystems.php',
        'config/hashing.php',
        'config/logging.php',
        'config/mail.php',
        'config/queue.php',
        'config/services.php',
        'config/session.php',
        'config/view.php',
    ];

    protected function setUp(): void
    {
        ServiceProvider::$configurePackageUsing = function (Package $package) {
            $this->configurePackage($package);
        };

        parent::setUp();

        testTime()->freeze('2020-01-01 00:00:00');

        $this->deletePublishedFiles();
        $this->createApplication();
    }

    protected function tearDown(): void
    {
        $this->deletePublishedFiles();
        $this->deleteMigrations();

        parent::tearDown();
    }

    abstract public function configurePackage(Package $package);

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function deletePublishedFiles(): self
    {
        $basePath = base_path() . '/';
        foreach ($this->cleanPaths as $dir) {
            if (! is_dir($basePath . $dir)) {
                continue;
            }
            collect(File::allFiles($basePath . $dir))->each(function (SplFileInfo $file) use ($basePath) {
                if (!in_array(Str::replace('\\', '/', Str::after($file->getPathname(), $basePath)), $this->cleanExclusions)) {
                    unlink($file->getPathname());
                }
            });
        }

        /* Clear publishes from previous tests */
        ServiceProvider::$publishes[ServiceProvider::class] = [];

        return $this;
    }

    protected function deleteMigrations(): self
    {
        /* Clear migrations from previous tests */
        $migrator = app('migrator');
        $reflection = new \ReflectionClass($migrator::class);
        $property = $reflection->getProperty('paths');
        $property->setAccessible(true);
        $property->setvalue($migrator, []);

        return $this;
    }
}
