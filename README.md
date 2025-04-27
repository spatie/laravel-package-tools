<div align="left">
    <a href="https://spatie.be/open-source?utm_source=github&utm_medium=banner&utm_campaign=laravel-package-tools">
      <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://spatie.be/packages/header/laravel-package-tools/html/dark.webp">
        <img alt="Logo for laravel-package-tools" src="https://spatie.be/packages/header/laravel-package-tools/html/light.webp" height="190">
      </picture>
    </a>

<h1>Tools for creating Laravel packages</h1>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-package-tools.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-package-tools)
![Tests](https://github.com/spatie/laravel-package-tools/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-package-tools.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-package-tools)

</div>

This package contains a `PackageServiceProvider` that you can use in your packages to easily register config files,
migrations, and more.

Here's an example of how it can be used.

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use MyPackage\ViewComponents\Alert;
use Spatie\LaravelPackageTools\Commands\Concerns;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('your-package-name')
            ->hasConfigFile()
            ->hasViews()
            ->hasViewComponent('spatie', Alert::class)
            ->hasViewComposer('*', MyViewComposer::class)
            ->sharesDataWithAllViews('downloads', 3)
            ->hasTranslations()
            ->hasAssets()
            ->publishesServiceProvider('MyProviderName')
            ->hasRoute('web')
            ->hasMigration('create_package_tables')
            ->hasCommand(YourCoolPackageCommand::class)
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub();
            });
    }
}
```

Under the hood it will do the necessary work to register the necessary things and make all sorts of files publishable.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-package-tools.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-package-tools)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can
support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.
You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards
on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Getting started

This package is opinionated on how you should structure your package. To get started easily, consider
using [our package-skeleton repo](https://github.com/spatie/package-skeleton-laravel) to start your package. The
skeleton is structured perfectly to work perfectly with the `PackageServiceProvider` in this package.

## Usage

To avoid needing to scroll through to find the right usage section, here is a Table of Contents:

* [Directory Structure](#directory-structure)
* [Making your functionality publishable](#making-your-functionality-publishable)
* [Getting Started](#getting-started)
* [Assets](#assets)
* [Blade Components](#blade-view-components)
* [Blade Anonymous Components](#blade-anonymous-components)
* [Blade Custom Directives](#blade-custom-directives)
* [Blade Custom Echo Handlers](#blade-custom-echo-handlers)
* [Blade Custom Conditionals](#blade-custom-conditionals)
* [Commands - Callable and Console](#commands-callable-and-console)
* [Optimize Commands (Laravel v11+)](#optimize-commands)
* [Config Files](#config-files)
* [Events & Listeners](#events-and-listeners)
* [Inertia Components](#inertia-components)
* [Livewire Views and Components](#livewire-views-and-components)
* [Database Migrations](#database-migrations)
* [Routes](#routes)
* [Publishable Service Providers](#publishable-service-providers)
* [Translations](#translations)
* [Views](#views)
* [View Composers](#view-composers)
* [Views Global Shared Data](#views-global-shared-data)
* [Creating and Install Command](#creating-an-install-command)
* [Lifecycle Hooks](#lifecycle-hooks)

### Directory Structure

This package is opinionated on how you should structure your package,
and by default expects a structure based on
[our package-skeleton repo](https://github.com/spatie/package-skeleton-laravel),
and to get started easily you should consider using this to start your package.

The structure for a package expected by default looks like this:

```
<root
<package root>/src/                       Default location for PackageServiceProvider extended class
<package root>/src/Commands/              Commands (callable and console-only)
<package root>/src/Components/            Blade components
<package root>/src/Providers/             Other Service Providers
<package root>/config/                    Mergeable and publishable config files
<package root>/database/factories/        Database factories
<package root>/database/migrations/       Publishable stubs and loadable migrations
<package root>/resources/dist/            Publishable assets
<package root>/resources/js/pages/        Inertia views
<package root>/resources/lang/            International translations
<package root>/resources/views/           Views
<package root>/routes/                    Routes
```

Note: When using paths in any Package method except `discoversMigrations()`,
the path given is relative to the location of your primary Service Provider
i.e. relative to `<package root>/src`
so e.g. `<package root>/ConfigFiles` would be specified as `../ConfigFiles`.

### Getting Started

In your package you should let your service provider extend `Spatie\LaravelPackageTools\PackageServiceProvider`.

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package) : void
    {
        $package->name('your-package-name');
    }
}
```

Defining your package name with a call to `name()` is mandatory.

**Note:** If your package name starts with `laravel-` then this prefix will be omitted
and the remainder of the name used as a short-name instead when publishing files etc.

And now let's look at all the different Laravel functions this supports...

assing the package name to `name` is mandatory.

### Assets

Any assets your package provides, should be placed in the `<package root>/resources/dist/` directory.

You can make these assets publishable the `hasAssets` method.

```php
$package
    ->name('your-package-name')
    ->hasAssets();
```

Users of your package will be able to publish the assets with this command:

```bash
php artisan vendor:publish --tag=your-package-name-assets
```

This will copy over the assets to the `public/vendor/<your-package-name>` directory in the app where your package is
installed in.

### Blade view components

Any Blade view components that your package provides should be placed in the `<package root>/src/Components` directory.

You can register these views with the `hasViewComponents` command.

```php
$package
    ->name('your-package-name')
    ->hasViewComponents('spatie', Alert::class);
```

This will register your view components with Laravel. In the case of `Alert::class`, it can be referenced in views
as `<x-spatie-alert />`, where `spatie` is the prefix you provided during registration.

Calling `hasViewComponents` will also make view components publishable, and will be published
to `app/Views/Components/vendor/<package name>`.

Users of your package will be able to publish the view components with this command:

```bash
php artisan vendor:publish --tag=your-package-name-components
```

### Commands - Callable and Console

You can register any command you package provides with the `hasCommand` function.

```php
$package
    ->name('your-package-name')
    ->hasCommand(YourCoolPackageCommand::class);
````

If your package provides multiple commands, you can either use `hasCommand` multiple times, or pass an array
to `hasCommands`

```php
$package
    ->name('your-package-name')
    ->hasCommands([
        YourCoolPackageCommand::class,
        YourOtherCoolPackageCommand::class,
    ]);
```

### Config Files

To register a config file, you should create a php file with your package name in the `config` directory of your
package. In this example it should be at `<package root>/config/your-package-name.php`.

If your package name starts with `laravel-`, we expect that your config file does not contain that prefix. So if your
package name is `laravel-cool-package`, the config file should be named `cool-package.php`.

To register that config file, call `hasConfigFile()` on `$package` in the `configurePackage` method.

```php
$package
    ->name('your-package-name')
    ->hasConfigFile();
```

The `hasConfigFile` method will also make the config file publishable. Users of your package will be able to publish the
config file with this command.

```bash
php artisan vendor:publish --tag=your-package-name-config
```

Should your package have multiple config files, you can pass their names as an array to `hasConfigFile`

```php
$package
    ->name('your-package-name')
    ->hasConfigFile(['my-config-file', 'another-config-file']);
```

### Inertia Components

Any `.vue` or `.jsx` files your package provides, should be placed in the `<package root>/resources/js/Pages` directory.

You can register these components with the `hasInertiaComponents` command.

```php
$package
    ->name('your-package-name')
    ->hasInertiaComponents();
```

This will register your components with Laravel.

The user should publish the inertia components manually or using the [installer-command](#adding-an-installer-command) in order to use them.

If you have an inertia component `<package root>/resources/js/Pages/myComponent.vue`, you can use it like
this: `Inertia::render('YourPackageName/myComponent')`. Of course, you can also use subdirectories to organise your components.

#### Publishing inertia components

Calling `hasInertiaComponents` will also make inertia components publishable. Users of your package will be able to publish the views with this
command:

```bash
php artisan vendor:publish --tag=your-package-name-inertia-components
```

Also, the inertia components are available in a convenient way with your package [installer-command](#adding-an-installer-command)

### Working with migrations

The `PackageServiceProvider` assumes that any migrations are placed in this
directory: `<package root>/database/migrations`. Inside that directory you can put any migrations.

To register your migration, you should pass its name without the extension to the `hasMigration` table.

If your migration file is called `create_my_package_tables.php.stub` you can register them like this:

```php
$package
    ->name('your-package-name')
    ->hasMigration('create_my_package_tables');
```

Should your package contain multiple migration files, you can just call `hasMigration` multiple times or
use `hasMigrations`.

```php
$package
    ->name('your-package-name')
    ->hasMigrations(['my_package_tables', 'some_other_migration']);
```

Alternatively, if you wish to publish all migrations in your package by default, you may call `discoversMigrations`.

```php
$package
    ->name('your-package-name')
    ->discoversMigrations();
```

Calling this method will look for migrations in the `./database/migrations` directory of your project. However, if you have defined your migrations
in a different folder, you may pass a value to the `$path` variable to instruct the app to discover migrations from that location.

```php
$package
    ->name('your-package-name')
    ->discoversMigrations(path: '/path/to/your/migrations/folder');
```

Calling either `hasMigration`, `hasMigration` or `discoversMigrations` will also make migrations publishable. Users of your package will be able to publish the
migrations with this command:

```bash
php artisan vendor:publish --tag=your-package-name-migrations
```

Like you might expect, published migration files will be prefixed with the current datetime.

You can also enable the migrations to be registered without needing the users of your package to publish them:

```php
$package
    ->name('your-package-name')
    ->hasMigrations(['my_package_tables', 'some_other_migration'])
    ->runsMigrations();
```

### Routes

The `PackageServiceProvider` assumes that any route files are placed in this directory: `<package root>/routes`. Inside
that directory you can put any route files.

To register your route, you should pass its name without the extension to the `hasRoute` method.

If your route file is called `web.php` you can register them like this:

```php
$package
    ->name('your-package-name')
    ->hasRoute('web');
```

Should your package contain multiple route files, you can just call `hasRoute` multiple times or use `hasRoutes`.

```php
$package
    ->name('your-package-name')
    ->hasRoutes(['web', 'admin']);
```

### Publishable Service Providers

Some packages need an example service provider to be copied into the `app\Providers` directory of the Laravel app. Think
of for instance, the `laravel/horizon` package that copies an `HorizonServiceProvider` into your app with some sensible
defaults.

```php
$package
    ->name('your-package-name')
    ->publishesServiceProvider($nameOfYourServiceProvider);
```

The file that will be copied to the app should be stored in your package
in `/resources/stubs/{$nameOfYourServiceProvider}.php.stub`.

When your package is installed into an app, running this command...

```bash
php artisan vendor:publish --tag=your-package-name-provider
```

... will copy `/resources/stubs/{$nameOfYourServiceProvider}.php.stub` in your package
to `app/Providers/{$nameOfYourServiceProvider}.php` in the app of the user.

### Translations

Any translations your package provides, should be placed in the `<package root>/resources/lang/<language-code>`
directory.

You can register these translations with the `hasTranslations` command.

```php
$package
    ->name('your-package-name')
    ->hasTranslations();
```

This will register the translations with Laravel.

Assuming you save this translation file at `<package root>/resources/lang/en/translations.php`...

```php
return [
    'translatable' => 'translation',
];
```

... your package and users will be able to retrieve the translation with:

```php
trans('your-package-name::translations.translatable'); // returns 'translation'
```

If your package name starts with `laravel-` then you should leave that off in the example above.

Coding with translation strings as keys, you should create JSON files
in `<package root>/resources/lang/<language-code>.json`.

For example, creating `<package root>/resources/lang/it.json` file like so:

```json
{
    "Hello!": "Ciao!"
}
```

...the output of...

```php
trans('Hello!');
```

...will be `Ciao!` if the application uses the Italian language.

Calling `hasTranslations` will also make translations publishable. Users of your package will be able to publish the
translations with this command:

```bash
php artisan vendor:publish --tag=your-package-name-translations
```

### Views

Any views your package provides, should be placed in the `<package root>/resources/views` directory.

You can register these views with the `hasViews` command.

```php
$package
    ->name('your-package-name')
    ->hasViews();
```

This will register your views with Laravel.

If you have a view `<package root>/resources/views/myView.blade.php`, you can use it like
this: `view('your-package-name::myView')`. Of course, you can also use subdirectories to organise your views. A view
located at `<package root>/resources/views/subdirectory/myOtherView.blade.php` can be used
with `view('your-package-name::subdirectory.myOtherView')`.

#### Using a custom view namespace

You can pass a custom view namespace to the `hasViews` method.

```php
$package
    ->name('your-package-name')
    ->hasViews('custom-view-namespace');
```

You can now use the views of the package like this:

```php
view('custom-view-namespace::myView');
```

#### Publishing the views

Calling `hasViews` will also make views publishable. Users of your package will be able to publish the views with this
command:

```bash
php artisan vendor:publish --tag=your-package-name-views
```

> **Note:**
>
> If you use custom view namespace then you should change your publish command like this:
```bash
php artisan vendor:publish --tag=custom-view-namespace-views
```

### View Composers

You can register any view composers that your project uses with the `hasViewComposers` method. You may also register a
callback that receives a `$view` argument instead of a classname.

To register a view composer with all views, use an asterisk as the view name `'*'`.

```php
$package
    ->name('your-package-name')
    ->hasViewComposer('viewName', MyViewComposer::class)
    ->hasViewComposer('*', function($view) {
        $view->with('sharedVariable', 123);
    });
```

### Views Global Shared Data

You can share data with all views using the `sharesDataWithAllViews` method. This will make the shared variable
available to all views.

```php
$package
    ->name('your-package-name')
    ->sharesDataWithAllViews('companyName', 'Spatie');
```

### Creating an Install Command

Instead of letting your users manually publishing config files, migrations, and other files manually, you could opt to
add an install command that does all this work in one go. Packages like Laravel Horizon and Livewire provide such
commands.

When using Laravel Package Tools, you don't have to write an `InstallCommand` yourself. Instead, you can simply
call, `hasInstallCommand` and configure it using a closure. Here's an example.

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Commands\Concerns;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('your-package-name')
            ->hasConfigFile()
            ->hasMigration('create_package_tables')
            ->publishesServiceProvider('MyServiceProviderName')
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('your-vendor/your-repo-name')
            });
    }
}
```

With this in place, the package user can call this command:

```bash
php artisan your-package-name:install
```

Using the code above, that command will:

- publish the config file
- publish the assets
- publish the migrations
- copy the `/resources/stubs/MyProviderName.php.stub` from your package to `app/Providers/MyServiceProviderName.php`, and also register that
  provider in `config/app.php`
- ask if migrations should be run now
- prompt the user to open up `https://github.com/'your-vendor/your-repo-name'` in the browser in order to star it

You can also call `startWith` and `endWith` on the `InstallCommand`. They will respectively be executed at the start and
end when running `php artisan your-package-name:install`. You can use this to perform extra work or display extra
output.

```php
use Spatie\LaravelPackageTools\Commands\Concerns;

public function configurePackage(Package $package): void
{
    $package
        // ... configure package
        ->hasInstallCommand(function(InstallCommand $command) {
            $command
                ->startWith(function(InstallCommand $command) {
                    $command->info('Hello, and welcome to my great new package!');
                })
                ->publishConfigFile()
                ->publishAssets()
                ->publishMigrations()
               ->askToRunMigrations()
                ->copyAndRegisterServiceProviderInApp()
                ->askToStarRepoOnGitHub('your-vendor/your-repo-name')
                ->endWith(function(InstallCommand $command) {
                    $command->info('Have a great day!');
                })
        });
}
```

### Lifecycle Hooks

You can put any custom logic your package needs while starting up in one of these methods:

- `registeringPackage`: will be called at the start of the `register` method of `PackageServiceProvider`
- `packageRegistered`: will be called at the end of the `register` method of `PackageServiceProvider`
- `bootingPackage`: will be called at the start of the `boot` method of `PackageServiceProvider`
- `packageBooted`: will be called at the end of the `boot` method of `PackageServiceProvider`

## Testing

```bash
composer test
```

This package now supports test groups as follows:

```bash
composer test -- --group=blade
```

The current groups suported are:
* base
* assets
* blade
* commands
* config
* inertia
* migrations
* provider
* routes
* shareddata
* translations
* viewcomposer
* views
* installer

Additionally, if you wish to test only backwards compatibility you can use:
* legacy

**Note:** `InvalidPackage` exceptions thrown during Laravel application bootup are reported by Pest,
but because the occur before the start of a test case
Pest by default does not allow you intentionally to test for them being thrown.
The tests in this package now include checks for intentional `InvalidPackage` exceptions being thrown
by catching and saving such exceptions in the TestServiceProvider,
and then rethrowing the exception at the very start of a Pest test case,
and this is achieved by loading a modified version of the Pest `test()` function
before anything else is loaded.
Whilst this is done for you if you run `composer test`,
if you want to run `vendor/bin/pest` directly you now need to run it like this:

```bash
php -d auto_prepend_file=tests/Prepend.php vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
