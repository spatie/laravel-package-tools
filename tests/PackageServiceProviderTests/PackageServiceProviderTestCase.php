<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

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

        $this->createApplication();
    }

    protected function tearDown(): void
    {
        $this
            ->deletePublishedFiles()
            ->clearServiceProviderStaticLists();

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
                if (! in_array(Str::replace('\\', '/', Str::after($file->getPathname(), $basePath)), $this->cleanExclusions)) {
                    if (! unlink($file->getPathname())) {
                        fwrite(STDERR, "Failed to delete: " . $file->getPathname() . PHP_EOL);
                    }
                }
            });
        }

        return $this;
    }

    /* Clear all Laravel ServiceProvider static arrays which are not otherwise cleared between tests */
    protected function clearServiceProviderStaticLists(): self
    {
        ServiceProvider::$publishes = [];
        ServiceProvider::$publishGroups = [];
        /* Following don't exist in Laravel 9.x or 10.x */
        if (property_exists(ServiceProvider::class, 'optimizeCommands')) {
            ServiceProvider::$optimizeCommands = [];
            ServiceProvider::$optimizeClearCommands = [];

            $reflection = new \ReflectionClass(ServiceProvider::class);
            $property = $reflection->getProperty('publishableMigrationPaths');
            $property->setAccessible(true);
            $property->setvalue(ServiceProvider::class, []);
        }

        return $this;
    }
}
