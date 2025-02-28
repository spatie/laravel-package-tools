<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

//use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProvider;
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
        'resources/views/components/',
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
    }

    protected function tearDown(): void
    {
        $this
            ->deletePublishedFiles()
            ->clearLaravelStaticRegistrations();

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
            $dir = $basePath . $dir;
            if (! is_dir($dir)) {
                continue;
            }
            collect(File::allFiles($dir))->each(function (SplFileInfo $file) use ($basePath) {
                if (! in_array(Str::replace('\\', '/', Str::after($file->getPathname(), $basePath)), $this->cleanExclusions)) {
                    if (! unlink($file->getPathname())) {
                        fwrite(STDERR, "Failed to delete: " . $file->getPathname() . PHP_EOL);
                    }
                }
            });

            if ($this->is_dir_empty($dir)) {
                rmdir($dir);
            }
        }

        return $this;
    }

    protected function is_dir_empty($dir): bool
    {
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                closedir($handle);
                return false;
            }
        }
        closedir($handle);
        return true;
    }

    /* Clear all Laravel ServiceProvider static arrays which are not otherwise cleared between tests */

    protected function clearLaravelStaticRegistrations(): self
    {
        ServiceProvider::reset();
        Facade::clearResolvedInstances();

        return $this;
    }

    protected function clearProtectedList(string $class, ... $properties): self
    {
        $reflection = new \ReflectionClass($class);
        foreach (collect($properties)->flatten()->toArray() as $property) {
            $reflectionProperty = $reflection->getProperty($property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setvalue($class, []);
        }

        return $this;
    }
}

