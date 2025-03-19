<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\TestServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

abstract class PackageServiceProviderTestCase extends TestCase
{
    protected array $cleanPathsFull = [
        'app/Livewire/',
        'app/View/Components/vendor/',
        'lang/vendor/',
        'public/vendor/',
        'resources/dist/',
        'resources/js/Pages/',
        'resources/views/components/',
        'resources/views/livewire/',
        'resources/views/vendor/',
    ];

    protected array $cleanPathsPartial = [
        'app/Providers/',
        'config/',
        'database/migrations/',
        'routes/',
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
        TestServiceProvider::$configurePackageUsing = function (Package $package) {
            $this->configurePackage($package);
        };

        parent::setUp();

        Event::fake();
    }

    protected function tearDown(): void
    {
        $this
            ->deletePublishedDirectoriesFull()
            ->deletePublishedDirectoriesPartial()
            ->clearLaravelStaticRegistrations();

        parent::tearDown();
    }

    abstract public function configurePackage(Package $package);

    protected function getPackageProviders($app)
    {
        return [
            TestServiceProvider::class,
        ];
    }

    protected function deletePublishedDirectoriesFull(): self
    {
        foreach ($this->cleanPathsFull as $dir) {
            File::deleteDirectory(base_path($dir));
        }

        return $this;
    }

    protected function deletePublishedDirectoriesPartial(): self
    {
        $basePath = base_path() . '/';
        foreach ($this->cleanPathsPartial as $dir) {
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

    /* Clear all Laravel TestServiceProvider static arrays which are not otherwise cleared between tests */

    protected function clearLaravelStaticRegistrations(): self
    {
        TestServiceProvider::reset();
        Facade::clearResolvedInstances();

        return $this;
    }

    /*
        protected function clearProtectedList(string $class, ...$properties): self
        {
            $reflection = new \ReflectionClass($class);
            foreach (collect($properties)->flatten()->toArray() as $property) {
                $reflectionProperty = $reflection->getProperty($property);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setvalue($class, []);
            }

            return $this;
        }
    */
}
