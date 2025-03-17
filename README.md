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

Version 2.0 extends the original package functionality to:

* Provide greater ability to load functions by path (and where appropriate multiple paths)
so as to mimic the autoload functionality provided by Laravel for certain paths
(see [Laravel's Directory Structure](https://laravel.com/docs/structure)).

* Have greater consistency about loading stuff individually by class or name,
or by path or (where appropriate) namespace.

* Have improved error checking functionality for inconsistent or invalid method calls

To provide a consistent API this has required some changes to the method names used,
however backwards compatibility with previous versions has been maintained so that
any upgrades should not break your valid existing `PackageServiceProvider` calls.

**Note:** Whilst all method calls are backwardly compatible,
where your package definition is not strictly valid
because e.g. a file or path you named is needed but doesn't exist,
you will now get an Invalid Package exception in non-production environments
when you previously didn't.

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
            ->hasAssets()
            ->hasConfigsByName()
            ->hasBladeComponentsByClass('spatie', Alert::class)
            ->hasBladeComposerByClass('*', MyViewComposer::class)
            ->hasCommandsbyClass(YourCoolPackageCommand::class)
            ->hasMigrationsByName('create_package_tables')
            ->hasRoutesByName('web')
            ->hasTranslations()
            ->hasViews();
    }
}
```

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-package-tools.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-package-tools)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source).
You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown,
mentioning which of our package(s) you are using.
You'll find our address on [our contact page](https://spatie.be/about-us).
We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Usage

To avoid needing to scroll through to find the right usage section, here is a Table of Contents:

* [Directory Structure](#directory-structure)
* [Getting Started](#getting-started)
* [Assets](#assets)
* [Blade Components](#blade-components)
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

Note: When using paths in any Package method,
the path given is relative to the location of your primary Service Provider
i.e. relative to `<package root>/src`
so `<package root>/ConfigFiles` would be set using `->setConfigsPath("../ConfigFiles")`
and `<package root>/src/ServiceProviders` would be set using  `->setPublishableServiceProvidersPath("ServiceProviders")`.

**Note:** If your primary Service Provider is located in `<package root>/src/Providers` then you can set
the base path with a call to `setBasePath(__DIR__ . '/../')`.

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

### Assets

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
however you can override this by specifying a path with `hasAssets()`:

```php
$package
    ->name('your-package-name')
    ->hasAssets(path: './assets/');
```

You can change the directory name it will be published to bu using a namespace i.e. to publish to `public/vendor/my-package` use:

```php
$package
    ->name('your-package-name')
    ->hasAssets('my-package');
```

Users of your package will be able to publish the assets with this command:

```bash
php artisan vendor:publish --tag=your-package-name-assets
```

and this will copy over the assets to the `public/vendor/<your-package-name>` directory
of the users application.

### Blade Components

There are three ways you can register and publish Blade (view) components:

1. Individually by class using `hasBladeComponentsByClass()`
2. By specifying the path for your Blade Components with `hasBladeComponentsByPath()`
3. Using the namespace root of your Blade Components with `hasBladeComponentsByNamespace()`

In each case, you need to provide a component prefix which will be used in a view
to load the component.

Your Blade components should be placed by default in the `<package root>/src/Components` directory.
And if you describe them by Class or Path (but not Namepace),
they can be published to `app/Views/Components/vendor/<package name>`
in the user's Laravel project with this command:

```bash
php artisan vendor:publish --tag=your-package-name-components
```

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
and they can then be referenced in Blade views as e.g. `<x-spatie::alert />`.

If you omit parameters, the default prefix is your short package name,
and the default path is `Components`.

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
this method only makes these views available and does **not** make these views publishable.

_See: [Laravel Package Development - Autoloading Package Components](https://laravel.com/docs/packages#autoloading-package-components)
for underlying details._

### Blade Anonymous Components

Blade Anonymous Components are an alternative way of creating Blade components
by combining the Blade component into the matching Blade view file
(in the same way that Livewire Volt combines the Livewire component into the Livewire view file).
_See [Laragon Blade - Anonymous Components]
(https://laravel.com/docs/blade#anonymous-components)._

Your Blade Anonymous Components should be placed by default
in the `<package root>/resources/views/components` directory.
Since they live in a subdirectory of `resources/views`
you can make them publishable them using `hasViews`,
however if you wish to register them for use as part of the package,
then call `hasBladeAnonymousComponentsByPath` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeAnonymousComponentsByPath('spatie');
```

and then the components can be used in Blade views as: `<x-spatie::my-component>`.

You can register and publish components in any other directory as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeAnonymousComponentsByPath('spatie1');
    ->hasBladeAnonymousComponentsByPath('spatie2', '../resources/views/my_components');
```

and then the use them in Blade views as: `<x-spatie1::my-component>` and `<x-spatie2::my-other-component>`.

If you omit parameters, the default prefix is your short package name,
and / or the default path is `../resources/views/components`.

Although it is perhaps best practice to define a package-specific prefix
in order to avoid naming clashes, you can use a null prefix in a package
so as to define a global component that can be used as `<x-my-component>`
as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeAnonymousComponentsByPath(null);
```

### Blade Custom Directives

Custom Blade directives allow you to add standardised functionality
(such as variable formatting e.g. `@datetime($var)`) to Blade views.
_See [Laragon Blade - Extending Blade](https://laravel.com/docs/blade#extending-blade)._

You can register Blade Directives using `hasBladeCustomDirective()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeCustomDirective('datetime', function ($expression): string {
        return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
    });
```

and use it as
```php
@datetime($var)
```

### Blade Custom Echo Handlers

Custom Blade echo handlers are an alternative way to define a default format for variables
of a specific object class instead of the standard `__toString()` method.
_See [Laragon Blade - Custom Echo Handlers](https://laravel.com/docs/blade#custom-echo-handlers)._

You can register Blade Echo Handlers using `hasBladeCustomEchoHandler()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeCustomEchoHandler(function (Money $money): string {
        return $money->formatTo('en_GB');
    });
```

Once you have done this you can use it in a Blade component or template
and the value will be automatically formatted
e.g. use `Cost: {{ $money }}` and the value will automatically be formed as GBP.

### Blade Custom Conditionals

Custom blade conditionals allow you to add standardised conditional processing to your Blade templates
(e.g. to display differently depending on a configuration variable).
_See [Laragon Blade - Custom If statements](https://laravel.com/docs/blade#custom-if-statements)._

You can register Blade conditionals using `hasBladeCustomIf()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasBladeCustomIf('disk', function ($value): bool {
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

### Commands - Callable and Console

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

If you omit the path, the default path is `Commands`.

### Optimize commands

From Laravel 11.27.1 onwards,
you can also define `short-package-name:optimize` and `short-package-name:clear-optimizations` commands
that can be run alongside Laravel's other optimizations (i.e. configuration, events, routes, and views)
when the user runs `artisan optimize` or `artisan optimize:clear`.

Assuming that you have already written and registered your two commands,
these can be registered for `artisan optimize` using the `hasOptimizeCommands()` as follows:

```php
$package
    ->name('your-package-name')
    ->hasConsoleCommands(Optimize::class, OptimizeClear::class)
    ->hasOptimizeCommands();
```
to use the above defaults or
```php
$package
    ->name('your-package-name')
    ->hasConsoleCommands(Optimize::class, OptimizeClear::class)
    ->hasOptimizeCommands('set-optimize', 'clear-optimize');
```
or to use different verbs or
```php
$package
    ->name('your-package-name')
    ->hasConsoleCommands(Optimize::class, OptimizeClear::class)
    ->hasOptimizeCommands('my-package:set-optimize', 'my-package:clear-optimize');
```
to explicitly define the full commands.

These commands can then be run normally as individual commands,
or will be also called as part fo a group with `artisan optimize`.

_See: [Laravel Package Development - Optimize Commands](https://laravel.com/docs/packages#optimize-commands)
for underlying details._

### Config Files

You can provide either actual config files (`*.php`) or stub config files (`*.php.stub`).
Actual config files will be both registered & if necessary merged
with any matching file created by the user,
and both actual and stub config files will be made publishable.

Your package's config files can be either loaded/published individually by name
or you can load/publish all the config files in your configuration file directory.

#### Config files individually by name

To register a config file, you should create a php file with your package name in the `config` directory of your
package. In this example it should be at `<package root>/config/your-package-name.php`.

Note: If your package name starts with `laravel-`, this prefix should be omitted from your config file name.
So if your package name is `laravel-cool-package`, the config file should be named `cool-package.php`.

To make your config file publishable and if a .php file merge it with any published version, call `hasConfigByName()`:

```php
$package
    ->name('your-package-name')
    ->hasConfigFiles();
```

Should your package have multiple config files, you can either call `hasConfigByName` multiple times
or pass their names as multiple arguments or an array to `hasConfigByName`.

```php
$package
    ->name('your-package-name')
    ->hasConfigByName([
        'my-config-file',
        'another-config-file'
    ]);
```

By default these assets are located in `<package root>/config/`,
however you can override this with `setConfigPath()`:

```php
$package
    ->name('your-package-name')
    ->hasConfigByName()
    ->setConfigPath('../configfiles/');
```

The `hasConfigByName` method will also make the config file(s) publishable,
and users of your package can publish the config file with this command.

```bash
php artisan vendor:publish --tag=your-package-name-config
```

By default, both *.php and *.php.stub files will be made publishable,
but if you have a mixture of these files and you want only the stub files to be published,
then please add a call to `publishOnlyStubs` as follows:

```php
$package
    ->name('your-package-name')
    ->hasConfigByName('my-config-file', 'my-config-stub')
    ->publishOnlyStubs();
```

**Note:** For backwards compatibility, `hasConfigFile` and `hasConfigFiles`
can still be used instead of `hasConfigByName`.

#### Config files individually by path

Alternatively you can merge / publish all the configuration files in the `<package root>/config`
directory without specifying them individually by name as follows:

```php
$package
    ->name('your-package-name')
    ->hasConfigByPath();
```

and override the default path as follows:

```php
$package
    ->name('your-package-name')
    ->hasConfigByPath('../configfiles/');
```

_See: [Laravel Package Development - Default Package Configuration](https://laravel.com/docs/packages#default-package-configuration)
for underlying details._

### Events and Listeners

Whilst Events & Listeners are less common in packages,
for Laravel applications large enough to need modules they are highly likely.

The normal locations in your package for Events classes would be `<package root>/src/Events` and
Listener classes in `<package root>/src/Listeners` but since you refer to these by Class name (i.e. `Listener::class`)
their location is a little less important than other files.

Event Listeners can be registered using Laravel Package Tools in several different ways:

* Using **Subscribers** - an Event Subscriber allows you to combine several Listeners
into a single Subscriber class, whose listeners can be automatically registered,
and which can handle them directly or farm them out to other classes.
These would seem to be most suitable for large modules.
* By **Event &Listener classes** - again this registers Listeners in other classes
* Several alternative ways to use anonymous Closure functions -
these are defined in the ServiceProvider rather than separate classes
and so seem suitable only for minor event/listener use.
    * Normal anonymous listeners
    * Queued anonymous listeners
    * Wildcard anonymous listeners - for anything significant use Subscribers instead.

#### Subscribers

Event subscribers are classes that may subscribe to multiple events from within the subscriber class itself,
allowing you to define several event handlers within a single class.

You can register Subscrber classes in your PackageServiceProvider as follows:
```php
$package
    ->name('your-package-name')
    ->hasEventSubscribers(SubscriberClass1::class)
    ->hasEventSubscribers(SubscriberClass2::class, SubscriberClass3::class);
```

_See: [Laravel docs - Event Subscribers](https://laravel.com/docs/events#event-subscribers)._

Event listeners can be registered either by class using `hasEventListenerByClass`

#### Event & Listener classes

```php
$package
    ->name('your-package-name')
    ->hasEventListenerByName(
        EventClass::class,
        [ListenerClass::class, "method"]
    );
```

The listener method can be omitted altogether if you use the standard "handle" method.

_See: [Laravel docs - Manually Registering Events & Listeners](https://laravel.com/docs/events#manually-registering-events)._

#### Anonymous Listeners & Queueable Anonymous Listeners

These are closures inside your Service Provider
and so should probably only be used for minor event handling
in order not to polute the ServiceProvider with functionality that should belong elsewhere
(e.g. in a Subscriber listener object).

```php
$package
    ->name('your-package-name')
    ->hasEventListenerAnonymous(function (EventClass $event) {
        //
    })
    ->hasEventListenerQueueableAnonymous(function (EventClass $event) {
        //
    });
```

_See: [Laravel Events - Closure Listeners](https://laravel.com/docs/events#closure-listeners)
for underlying details._

#### Wildcard Anonymous Listeners

Normal Events are defined using an Event Object,
and events are dispatched by `EventObject::dispatch(<payload>)`
and are sent to Listeners which use the fully qualified Event Object name
(e.g. `EventObject::class`).
Under the covers `EventObject::dispatch(<payload>)` is converted to
`Event::dispatch(EventObject::class, new EventObject(<payload>))`.

However, Listeners do NOT need to be associated with Event Objects;
they can be associated with any string name,
and typically dot notation e.g. `user.login` is used for these names
(and indeed this format is still used for Broadcasting in order to use
the same name at the other end of the Broadcast where
PHP/Laravel Event Object names would make much less sense - see `BroadcastAs`).

And this is where wildcard listeners come in...

When you do `Event::dispatch(name, <payload>)`
this can be matched to a Listener using a wildcard string.
So a Listener that uses the wildcard string (e.g. `user.*`)
will match `Event::dispatch('user.login')` etc.
but it could also use a partially-qualified Event Object names
(e.g. `Spatie\Package\Events\User*` or `App\Domain\*\Events\UserLogin`)
which would then be matched by `Spatie\Package\Events\UserLogin::dispatch()`
or `App\Domain\Profile\Events\UserLogin::dispatch()`.

And this is where Wildcard Anonymous Listeners come in -
they are exactly like normal listeners,
except that the full event name is passed
as an additional first parameter before the payload.

```php
$package
    ->name('your-package-name')
    ->hasEventListenerWildcardByClosure('user.*', function (string $eventName, ...$payload) {
        //
    })
    ->hasEventListenerWildcardByClass('user.*', [WildcardListener::class, 'wildcardHandle']);
```

_See: [Laravel Events - Wildcard Listeners](https://laravel.com/docs/events#wildcard-event-listeners)
for underlying details (though the Laravel documentation in less explanatory than above)._

### Inertia Components

If you have an Inertia component `<package root>/resources/js/Pages/myComponent.vue`,
you can publish it and use it like this: `Inertia::render('YourPackageName/myComponent')`.
Of course, you can also use subdirectories to organise your components.

```php
$package
    ->name('your-package-name')
    ->hasInertiaComponents();
```

Your `.vue` or `.jsx` files should be placed by default in the `<package root>/resources/js/Pages` directory,
or you can override this with another path by:

```php
$package
    ->name('your-package-name')
    ->hasInertiaComponents(path: '../resources/js/Inertia');
```

You can also use multiple paths with separate tag namespaces:

```php
$package
    ->name('your-package-name')
    ->hasInertiaComponents(path: '../resources/js/Inertia')
    ->hasInertiaComponents('more', '../resources/js/MoreInertia');
```

Your Inertia components will be published
using the short-name of your package as a tag namespace.

```bash
php artisan vendor:publish --tag=your-package-name-inertia-components
```
and use them as: `Inertia::render('MyInertiaNamespace/myComponent')`.

For backwards compatibility reasons, if you use an alternative namespace,
the user can also publish them using:

```bash
php artisan vendor:publish --tag=my-inertia-namespace-inertia-components
```

Also, the Inertia components are available in a convenient way with your package [installer-command](#installer-command).

**Note:** If you wish to load these Inertia components directly rather than publishing them,
the you may be able to use the [Inertia Page Loader plugin](https://github.com/ycs77/inertia-page-loader)
that allows you to add paths in your package as a source for Inertia components.

### Livewire Views and Components

Like Blade, Livewire also consists of views and components,
and like Blade when using Livewire Volt the Livewire component can be included in the matching view file.

If you are **not** using Livewire Volt,
your Livewire components should be placed by default in the `<package root>/src/Livewire` directory,
and they can be made publishable to `app/Livewire/vendor/your-package-name` by using `hasLivewireComponents()`:

```php
$package
    ->name('your-package-name')
    ->hasViews()
    ->hasLivewireComponents();
```

You can override this with another path with:

```php
$package
    ->name('your-package-name')
    ->hasViews()
    ->hasLivewireComponents(path: 'LivewireComponents');
```

and you can specify several paths with:

```php
$package
    ->name('your-package-name')
    ->hasViews()
    ->hasLivewireComponents()
    ->hasLivewireComponents('my-livewire', 'LivewireComponents');
```

Your Livewire components can be published using:

```bash
php artisan vendor:publish --tag=your-package-name-livewire-components
```

### Database Migrations

You can provide either actual migration files (`*.php`) or stub migration files (`*.php.stub`),
and for `*.php` files if you call `loadsMigrations` they will also be loaded
so that if the user runs `artisan migrate` these migrations will be run.
Both actual and stub migration files will be made publishable.

Your package's migration files can be either loaded/published individually by name
or you can load/publish all the migration files in your migrations directory.

### Database migrations by name
To register a migration file for running as-is,
you should create a php file in the `../database/migrations` directory
of your package.
In this example it should be
e.g. `<package root>/database/migrations/create_my_package_table.php`.
or `<package root>/database/migrations/create_my_package_table.php.stub`,
though the location of this can be changed by calling `setMigrationsPath`.

To add your migration file, you should pass its name without the extension to the `hasMigrationsByName` method.
If your migration file is called `create_my_package_tables.php` or `create_my_package_tables.php.stub`
you add it to your package like this:

```php
$package
    ->name('your-package-name')
    ->hasMigrationsByName('create_my_package_table');
```

Should your package contain multiple migration files,
you can call `hasMigrationsByName` multiple times or
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

By default, both *.php and *.php.stub files will be made publishable,
but if you have a mixture of these files and you want only the stub files to be published,
then please add a call to `publishOnlyStubs` as follows:

```php
$package
    ->name('your-package-name')
    ->hasMigrationByName('my-config-file', 'my-config-stub')
    ->publishOnlyStubs();
```

**Note:** For backwards compatibility, `hasMigration` or `hasMigrationsByName` can still be used instead of `hasMigrations`,
`discoversMigrations` instead of `hasMigrationsByPath`
and `runsMigrations` instead of `loadsMigrations`.

_See: [Laravel Package Development - Migrations](https://laravel.com/docs/packages#migrations)
for underlying details._

### Routes

You can provide either actual route files (`*.php`) or stub route files (`*.php.stub`).
Actual route files can be loaded,
and both actual and stub config files will be made publishable.

Your package's config files can be either loaded/published individually by name
or you can load/publish all the config files in your configuration file directory.

Laravel Package Tools assumes that any route files are placed in this directory: `<package root>/routes`.

To register your route files, you should pass their names without the extension to the `hasRoutesByName` method.

If your route file is called `web.php` you can register them like this:

```php
$package
    ->name('your-package-name')
    ->hasRoutesByName('web');
```

Should your package contain multiple route files,
you can just call `hasRoutesByName` multiple times
or use `hasRoutesByName` with several arguments or as an array.

```php
$package
    ->name('your-package-name')
    ->hasRoutesByName('web', 'api')
    ->hasRoutesByName(['admin', 'superuser']);
```

Your routes can be published using:

```bash
php artisan vendor:publish --tag=your-package-name-routes
```

### Publishable Service Providers

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
This includes:
* Normal Blade views
* Blade Anonymous Components
* Livewire views
* Livewire Volt Components

You can register these views with the `hasViews` command.

```php
$package
    ->name('your-package-name')
    ->hasViews();
```

This will register your Blade views with Laravel, and make the `<package root>/views` directory (and all sub-directories) publishable.

If you have a Blade view `<package root>/resources/views/myView.blade.php`,
you can use it like this: `view('your-package-name::myView')`.
Of course, you can also use subdirectories to organise your views.
A view located at `<package root>/resources/views/subdirectory/myOtherView.blade.php`
can be used with `view('your-package-name::subdirectory.myOtherView')`.

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

**Note:**

If you use custom view namespace then you can continue to use the above command
or change your publish command like this:
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

**Note:** This is global shared data, available to every view,
and you need to take care to avoid name clashes with other e.g. other packages.
It is recommended that the name of any shared data be prefixed with your package name.

### Modifiers

#### isModule()

If you are using PackageServiceProvider to support a Modular monolith Laravel app,
then add a call to `isModule()`.

At present the scope of this is to prevent all items being published.

#### onlyPublishStubs()

If you are using PackageServiceProvider to support a Laravel package,
and you have config files or migration files or route files that include both
actual .php files which will be loaded as configs/migrations/routes
**and** .php.stub files which are only intended to be published,
then it might be that you will only want to make the .php.stub files publishable
and **not** the .php files. If this is the case then add a call to `onlyPublishStubs()`.

### Creating an Install Command

Instead of instructing your users to run multiple artisan commands to
individually publish e.g. config files, migrations etc.,
you can create an `artisan package-name:install` command that can streamline this
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

### Lifecycle Hooks

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

**Note:** `InvalidPackage` exceptions thrown during Laravel application bootup are reported by Pest,
but because the occur before the start of a test case
Pest by default does not allow you intentionally to test for them being thrown.
The tests in this package now include checks for intentional `InvalidPackage` exceptions being thrown
by catching and saving such exceptions in the Testing ServiceProvider,
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
