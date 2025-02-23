# Tools for creating Laravel packages

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-package-tools.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-package-tools)
![Tests](https://github.com/spatie/laravel-package-tools/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-package-tools.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-package-tools)

This package contains a `PackageServiceProvider` that you can use in your packages
to easily register config files, migrations, and more,
and to register files as publishable so that they can be copied over to the users application
and even to create an installer Artisan command.

Whilst the intended use is to assist package developers more easily
to integrate their package with Laravel,
this also has all the functionality you need to modularise large applications.

Version x extends the original package functionality to:

* Provide greater ability to load functions by path (and where appropriate multiple paths)
so as to mimic the autoload functionality for certain paths in the default Laravel application
(see [Laravel's Directory Structure](https://laravel.com/docs/structure)).

* Have greater consistency about loading stuff individually by class or name,
or by path or (where appropriate) namespace.

* Have improved error checking functionality for inconsistent or invalid method calls

To provide a consistent API this has required some changes to the method names used,
however backwards compatibility with previous versions has been maintained so that
any upgrades should not break your existing `PackageServiceProvider` calls.

Here's an example of how it can be used.

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use MyPackage\ViewComponents\Alert;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('your-package-name')
            ->hasAssets()
            ->hasConfigFiles()
            ->hasBladeComponentsByClass('spatie', Alert::class)
            ->hasBladeComposerByClass('*', MyViewComposer::class)
            ->hasCommandsbyClass(YourCoolPackageCommand::class)
            ->hasMigrations('create_package_tables')
            ->hasRoutes('web')
            ->hasTranslations()
            ->hasViews()
            ->sharesDataWithAllViews('downloads', 3)
            ->publishesServiceProvider('MyProviderName')
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

Under the hood it will do the necessary work to register the necessary things
and make all sorts of files publishable.

Laravel Package Tools can also be used to modularise your application as follows:

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use MyPackage\ViewComponents\Alert;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('module-name')
            ->isModule()
            ->hasAssets()
            ->hasConfigFiles()
            ->hasBladeComponentsByClass('spatie', Alert::class)
            ->hasBladeComposerByClass('*', MyViewComposer::class)
            ->hasCommandsbyClass(YourCoolPackageCommand::class)
            ->hasMigrations('create_package_tables')
            ->hasRoutes('web')
            ->hasTranslations()
            ->hasViews();
    }
}
```

At present the `isModule` method simply prevents anything being published.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-package-tools.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-package-tools)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source).
You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown,
mentioning which of our package(s) you are using.
You'll find our address on [our contact page](https://spatie.be/about-us).
We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Usage

### Directory structure

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
<package root>/src/Livewire/              Livewire components
<package root>/src/Providers/             Other Service Providers
<package root>/config/                    Mergeable and publishable config files
<package root>/database/factories/        Database factories
<package root>/database/migrations/       Publishable stubs and loadable migrations
<package root>/resources/dist/            Publishable assets
<package root>/resources/js/pages/        Inertia views
<package root>/resources/lang/            International translations
<package root>/resources/views/           Views
<package root>/resources/views/Livewire/  Livewire Views (inc. Volt combined views/components)
<package root>/routes/                    Routes
```

However most of these default paths can be changed if necessary using a `setXXXXPath("path")` call.

Note: When overriding paths the path given is relative to the location of your primary Service Provider
i.e. relative to `<package root>/src`
so `<package root>/ConfigFiles` would be set using `->setConfigsPath("../ConfigFiles")`
and `<package root>/src/ServiceProviders` would be set using  `->setPublishableServiceProvidersPath("ServiceProviders")`.

**Note:** If your primary Service Provider is located in `<package root>/src/Providers` then you can set
the base path with a call to `setBasePath(__DIR__ . '/../')`.

### Getting started

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

### Publishing Assets

Assets are usually non-php files that are used by your views e.g. such as graphics
that you can make publishable by calling `hasAssets()`
so that they can be published into the `public/vendor/short-package-name` directory of
the Laravel project:

```php
$package
    ->name('your-package-name')
    ->hasAssets();
```

By default these assets are located in `<package root>/resources/dist`,
however you can override this with `setAssetPath()`:

```php
$package
    ->name('your-package-name')
    ->hasAssets()
    ->setAssetsPath('/../assets/');
```

Users of your package will be able to publish the assets with this command:

```bash
php artisan vendor:publish --tag=your-package-name-assets
```

and this will copy over the assets to the `public/vendor/<your-package-name>` directory
of the users application.

**Note:** At present only one assets path can be published.
If there is a need, this can be extended like many other functions to support multiple paths.

### Blade components

There are three ways you can register and publish Blade (view) components:

1. Individually by class using `hasBladeComponentsByClass()`
2. By specifying the path for your Blade Components with `hasBladeComponentsByPath()`
3. Using the namespace root of your Blade Components with `hasBladeComponentsByNamespace()`

In each case, you need to provide a component prefix which will be used in a view
to load the component.

Your Blade components should be placed by default in the `<package root>/src/Components` directory.

#### Registering and publishing Blade Components individually by class

You can register and publish Blade components individually by name with the `hasBladeComponentsByClass` method.

```php
use MyPackage\Components\Alert;
use MyPackage\Components\Message;
use MyPackage\Components\Email;
use MyPackage\Components\Banner;
use MyPackage\Components\Menu;


$package
    ->name('your-package-name')
    ->hasBladeComponentsByClass('spatie', Alert::class)
    ->hasBladeComponentsByClass('spatie', Message::class, Email::class)
    ->hasBladeComponentsByClass('spatie', [Banner::class, Menu::class]);
```

This will register the individual Blade components with Laravel,
and they can then be referenced in Blade views as e.g. `<x-spatie-alert />`,
where `spatie` is the prefix you provided during registration,
and `alert` is the lower-case version of the class name.

Calling `hasBladeComponentsByClass` will also make view components publishable,
and they will be published to `app/Views/Components/vendor/<package name>`
in the user's Laravel project with this command:

```bash
php artisan vendor:publish --tag=your-package-name-components
```

**Note:** For backwards compatibility, `hasViewComponents` & `hasViewComponents`
can still be used instead of `hasBladeComponentsByClass`.

_See: [Laravel Package Development - View Components](https://laravel.com/docs/packages#view-components)
for underlying details._

#### Registering and publishing Blade Components by Path

The second way to register Blade components is by path
using `hasBladeComponentsByPath()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeComponentsByPath('spatie', "Components/spatie")
    ->hasBladeComponentsByPath('spatie2', "Components/spatie2");
```
For each path, this will determine the namespace
by evaluating the first php file in the path,
and then register the namespace with Laravel (like `hasBladeComponentsByNamespace`),
and they can then be referenced in Blade views as e.g. `<x-spatie::alert />`

Calling `hasBladeComponentsByPath` will also make view components publishable,
and they will be published to `app/Views/Components/vendor/your-package-name/`
in the user's Laravel project with this command:

```bash
php artisan vendor:publish --tag=your-package-name-components
```

#### Registering Blade Components by Namespace

The final way to register Blade components is by namespace
using `hasBladeComponentsByNamespace()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeComponentsByNamespace('spatie', "MyPackage\\ViewComponents")
    ->hasBladeComponentsByNamespace('spatie2', "MyPackage\\ViewComponents2");
```

This will register the individual Blade component namespaces with Laravel,
and they can then be referenced in Blade views as e.g. `<x-spatie::alert />`

**Note:** Because it is tricky to determine the path associated with a namespace,
this method only makes these views available and does **not** publish these views.

_See: [Laravel Package Development - Autoloading Package Components](https://laravel.com/docs/packages#autoloading-package-components)
for underlying details._

### Custom Blade Directives

Custom Blade directives allow you to add standardised functionality
(such as variable formatting e.g. `@datetime($var)`) to Blade views.
_See [Laragon Blade - Extending Blade](https://laravel.com/docs/blade#extending-blade)._

You can register Blade Directives using `hasBladeCustomDirective()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeCustomDirective('datetime', function ($expression) {
        return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
    });
```

and use it as
```php
@datetime($var)
```

### Custom Blade Echo Handlers

Custom Blade echo handlers are an alternative way to define a default format for variables
of a specific object class instead of the standard `__toString()` method.
_See [Laragon Blade - Custom Echo Handlers](https://laravel.com/docs/blade#custom-echo-handlers)._

You can register Blade Echo Handlers using `hasBladeCustomEchoHandler()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeCustomEchoHandler(function (Money $money) {
        return $money->formatTo('en_GB');
    });
```

Once you have done this you can use it in a Blade component or template
and the value will be automatically formatted
e.g. use `Cost: {{ $money }}` and the value will automatically be formed as GBP.

### Custom Blade conditionals

Custom blade conditionals allow you to add standardised conditional processing to your Blade templates
(e.g. to display differently depending on a configuration variable).
_See [Laragon Blade - Custom If statements](https://laravel.com/docs/blade#custom-if-statements)._

You can register Blade conditionals using `hasBladeCustomIf()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeCustomIf('disk', function ($value) {
        return config('filesystems.default') === $value;
    });
```

and then you can use this as follows:

```php
@disk('local')
    <!-- The application is using the local disk... -->
@elsedisk('s3')
    <!-- The application is using the s3 disk... -->
@else
    <!-- The application is using some other disk... -->
@enddisk

@unlessdisk('local')
    <!-- The application is not using the local disk... -->
@enddisk
```

### Callable and Console commands

Custom Artisan commands can be registered with Laravel, either as:

* **Commands** that can be run either by calling them from Laravel code or from the console as an Artisan command
* **Console commands** that can only be run from the console as an Artisan command

There are two ways you can register and publish commands:

1. Individually by class using `hasCommandsByClass()` or `hasConsoleCommandsByClass()`
2. By specifying the path for your Commands with `hasCommandsByPath()` or `hasConsoleCommandsByPath()`

_See: [Laravel Package Development - Commands](https://laravel.com/docs/packages#commands)
for underlying details._

#### Registering Commands by Class

You can register any callable commands your package provides with the `hasCommandsByClass` function,
and console-only commands with the `hasConsoleCommandsByClass`.
If your package provides multiple commands,
you can either use `hasCommandsByClass` or `hasConsoleCommandsByClass` multiple times,
or use multiple arguments or pass an array to `hasCommandsByClass` / `hasConsoleCommandsByClass`.

```php
$package
    ->name('your-package-name')
    ->hasCommandsByClass(Command1::class)
    ->hasCommandsByClass(
        Command2::class,
        Command3::class
    )
    ->hasConsoleCommandsByClass([Command4::class, Command5::class]);
```

**Note:** For backwards compatibility, `hasCommand` can still be used instead of `hasCommandsByClass`,
and `hasConsoleCommand` for `hasConsoleCommandsByClass`.

#### Registering Commands by Path

Alternatively you can load all the commands in one or more paths as follows:

```php
$package
    ->name('your-package-name')
    ->hasConsoleCommandsByPath('Console/Commands');
```

### Optimize/Optimize:Clear commands

In Laravel 11 onwards, you can also define custom `artisan optimize` and `artisan optimize:clear`
commands that can be set and cleared alongside Laravel's other optimization functionality
(i.e. configuration, events, routes, and views),
and these can be specified using the `hasOptimizeCommands()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasOptimizeCommands(
        YourCoolPackageOptimizeCommand::class,
        YourCoolPackageOptimizeClearCommand::class,
    );
```

_See: [Laravel Package Development - Optimize Commands](https://laravel.com/docs/packages#optimize-commands)
for underlying details._

### Config file(s)

You can provide either actual config files (`*.php`) or stub config files (`*.php.stub`)
and by default these should be placed in `<package root>/config`,
though the location of this can be changed by calling `setConfigPath`.

To register a config file, you should create a php file with your package name in the `config` directory of your
package. In this example it should be at `<package root>/config/your-package-name.php`.

Note: If your package name starts with `laravel-`, this prefix should be omitted from your config file name.
So if your package name is `laravel-cool-package`, the config file should be named `cool-package.php`.

Both actual and stub config files will be made publishable.
Actual config files will also be loaded and / or merged with published versions.

To make your config file publishable and if an actual file merge it with any published version, call `hasConfigFiles()`:

```php
$package
    ->name('your-package-name')
    ->hasConfigFiles();
```

Should your package have multiple config files, you can either call `hasConfigFiles` multiple times
or pass their names as an array to `hasConfigFiles`.

```php
$package
    ->name('your-package-name')
    ->hasConfigFiles([
        'my-config-file',
        'another-config-file'
    ]);
```

By default these assets are located in `<package root>/config/`,
however you can override this with `setConfigPath()`:

```php
$package
    ->name('your-package-name')
    ->hasConfigFiles()
    ->setConfigPath('../configfiles/');
```

The `hasConfigFiles` method will also make the config file(s) publishable,
and users of your package can publish the config file with this command.

```bash
php artisan vendor:publish --tag=your-package-name-config
```

**Note:** For backwards compatibility, `hasConfigFile` can still be used instead of `hasConfigFiles`.

_See: [Laravel Package Development - Default Package Configuration](https://laravel.com/docs/packages#default-package-configuration)
for underlying details._

### Event Listeners

Event listeners can be registered either by class using `hasEventListenerByClass`
or anonymous callable i.e. function using `hasEventListenerAnonymous`
or with an inline queueable anonymous callable using `hasEventListenerQueueable`:

```php
$package
    ->name('your-package-name')
    ->hasEventListenerByClass(
        EventClass::class,
        [ListenerClass::class, "method"]
    )
    ->hasEventListenerAnonymous(function (EventClass $event) {
        //
    })
    ->hasEventListenerQueueable(function (EventClass $event) {
        //
    });
```

_See: [Laravel Events - Manually Registering Events](https://laravel.com/docs/events#manually-registering-events)
for underlying details._

### Inertia components

If you have an Inertia component `<package root>/resources/js/Pages/myComponent.vue`,
you can publish it and use it like this: `Inertia::render('YourPackageName/myComponent')`.
Of course, you can also use subdirectories to organise your components.

```php
$package
    ->name('your-package-name')
    ->hasInertiaComponents();
```

Your `.vue` or `.jsx` files should be placed by default in the `<package root>/resources/js/Pages` directory,
or you can override this with another path by calling `setInertiaPath`.

```php
$package
    ->name('your-package-name')
    ->hasInertiaComponents()
    ->setInertiaPath('../resources/js/Inertia');
```

By default your Inertia components will be published
using the short-name of your package as a tag namespace.

```bash
php artisan vendor:publish --tag=your-package-name-inertia-components
```

Alternatively you can define an alternative namespace
by calling `hasInertiaComponents('my-inertia-namespace')`
and then the user can publish them using:

```bash
php artisan vendor:publish --tag=my-inertia-namespace-inertia-components
```

and use them as: `Inertia::render('MyInertiaNamespace/myComponent')`.

Also, the Inertia components are available in a convenient way with your package [installer-command](#installer-command).

**Note:** If you wish to load these Inertia components directly rather than publishing them,
the you may be able to use the [Inertia Page Loader plugin](https://github.com/ycs77/inertia-page-loader)
that allows you to add paths in your package as a source for Inertia components.

### Livewire views and components

Like Blade, Livewire also consists of views and components,
(though when using Livewire Volt these can be combined into a single view file).

```php
$package
    ->name('your-package-name')
    ->hasLivewireComponents();
```

Your Livewire views should be placed by default in the `<package root>/resources/views/livewire` directory,
or you can override this with another path by calling `setLivewireViewsPath`.
Your Livewire components should be placed by default in the `<package root>/src/Livewire` directory,
or you can override this with another path by calling `setLivewireComponentsPath`.

```php
$package
    ->name('your-package-name')
    ->hasLivewireComponents()
    ->setLivewireViewsPath('../resources/views/LivewireViews')
    ->setLivewireComponentsPath('LivewireComponents');
```

By default your Inertia components will be published using the short-name of your package as a tag namespace.

```bash
php artisan vendor:publish --tag=your-package-name-livewire-components
```

Alternatively you can define an alternative namespace
by calling `hasLivewireComponents('my-livewire-namespace')`
and then the user can publish them using:

```bash
php artisan vendor:publish --tag=my-livewire-namespace-livewire-components
```

### Database Migrations

You can provide either actual migration files (`*.php`) or stubs (`*.php.stub`)
and by default these should be placed in `<package root>/database/migrations`,
though the location of this can be changed by calling `setMigrationsPath`.

Both `*.php` and `*.php.stub` migration files will be published (as `.php` files),
and for `*.php` files if you call `loadMigrations` they will also be loaded
so that if the user runs `artisan migrate` these migrations will be run.

To add your migration file, you should pass its name without the extension to the `hasMigrations` method.
If your migration file is called `create_my_package_tables.php` or `create_my_package_tables.php.stub`
you add it to your package like this:

```php
$package
    ->name('your-package-name')
    ->hasMigrations('create_my_package_tables');
```

Should your package contain multiple migration files,
you can call `hasMigrations` multiple times or
pass multiple arguments or an array of filenames in one call.

```php
$package
    ->name('your-package-name')
    ->hasMigrations(['my_package_tables', 'some_other_migration']);
```

Alternatively, if you wish to load or publish all migrations in your package without naming them individually,
you may call `discoversMigrations`.

```php
$package
    ->name('your-package-name')
    ->discoversMigrations();
```

Calling this method will look for migrations in the `./database/migrations` directory of your project.
However, if you have defined your migrations in a different folder,
you may pass a value to the `$path` variable to instruct the app to discover migrations from that location.

```php
$package
    ->name('your-package-name')
    ->discoversMigrations(path: '/path/to/your/migrations/folder');
```

Calling either `hasMigrations` or `discoversMigrations` will also make migrations publishable.
Users of your package will be able to publish the migrations with this command:

```bash
php artisan vendor:publish --tag=your-package-name-migrations
```

Like you might expect, published migration files will be prefixed with the current datetime.

You can also enable the migrations to be loaded (from their existing location within the package)
ready for running with `artisan migrate` without needing the users of your package to publish them:

```php
$package
    ->name('your-package-name')
    ->hasMigrations(['my_package_tables', 'some_other_migration'])
    ->loadsMigrations();
```

**Note:** For backwards compatibility, `hasMigration` can still be used instead of `hasMigrations`,
and `runMigrations` instead of `loadMigrations`.

_See: [Laravel Package Development - Migrations](https://laravel.com/docs/packages#migrations)
for underlying details._

### Routes

Laravel Package Tools assumes that any route files are placed in this directory: `<package root>/routes`. Inside
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

### Publishable service providers

Some packages need one or more example service providers to be copied
into the `app\Providers` directory of the Laravel app.
For instance, the `laravel/horizon` package copies an `HorizonServiceProvider`
into your app with some sensible defaults.

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


### Views shared global data

You can share data with all views using the `sharesDataWithAllViews` method. This will make the shared variable
available to all views.

```php
$package
    ->name('your-package-name')
    ->sharesDataWithAllViews('companyName', 'Spatie');
```

**Note:** This is global shared data, available to every view,
and you need to take care to avoid name clashes with other e.g. other packages.
It is recommended that the name of any shared data be prefixed with your package name.

### Install with `artisan your-package-name:install`

Instead of instructing your users to run multiple artisan commands to individually publish
e.g. config files, migrations etc.,
you can create an artisan `package-name:install` command that can streamline this
by running all the publishes you need using this single command.
Packages like Laravel Horizon and Livewire already provide such commands,
and Laravel Package Tools makes it easy for you to do the same.

When using Laravel Package Tools, you don't have to write an `InstallCommand` yourself.
Instead, you can simply call, `hasInstallCommand` and configure it using a closure.

Here is a list of things you can do with the `hasInstallCommand`:

* Publish one or several types of file i.e. run several artisan vendor:publish commands with various --tags
* Ask the user whether to run migrations (including but not limited to your packages migrations)
* Ask the user whether to star the Github repo for your package
* Run yor own custom callables before and after running the rest of the installer

Here's an example.

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Commands\InstallCommand;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('your-package-name')
            ->hasConfigFile()
            ->hasMigration('create_package_tables')
            ->publishesServiceProvider('MyServiceProviderName')
            ->hasInstallCommand(function(InstallCommand $installer) {
                $installer
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
- copy the `/resources/stubs/MyProviderName.php.stub` from your package
  to `app/Providers/MyServiceProviderName.php`, and also register that
  provider in `config/app.php` (Laravel <= v10) or `bootstrap/providers.php` (Laravel >= v11)
- ask if migrations should be run now
- prompt the user to open up `https://github.com/'your-vendor/your-repo-name'` in the browser in order to star it

You can also call `startWith` and `endWith` on the `InstallCommand`. They will respectively be executed at the start and
end when running `php artisan your-package-name:install`. You can use this to perform extra work or display extra
output.

```php
use Spatie\LaravelPackageTools\Commands\InstallCommand;

public function configurePackage(Package $package): void
{
    $package
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

### Lifecycle hooks

You can put any custom logic your package needs while starting up in one of these methods:

- `registeringPackage`: will be called at the start of the `register` method of `PackageServiceProvider`
- `packageRegistered`: will be called at the end of the `register` method of `PackageServiceProvider`
- `bootingPackage`: will be called at the start of the `boot` method of `PackageServiceProvider`
- `packageBooted`: will be called at the end of the `boot` method of `PackageServiceProvider`

Alternatively you can create `register` and `boot` methods and call the equivalent parent function before
adding your own register or boot functionality i.e.:

```php
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class YourPackageServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('your-package-name')
            ...;
    }

    public function register()
    {
        // Put your registeringPackage code here

        parent::register();

        // Your packageRegistered code here
    }

    public function boot()
    {
        // Put your bootingPackage code here

        parent::boot();

        // Put your packageBooted code here
    }
}
```

## Testing

```bash
composer test
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
