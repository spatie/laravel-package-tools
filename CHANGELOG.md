# Changelog

All notable changes to `laravel-package-tools` will be documented in this file.

## 1.20.0 - 2025-03-01

### What's Changed

* Major improvements by @Sophist-UK in https://github.com/spatie/laravel-package-tools/pull/158
  - Extend the restructing/readability/extendability approach started in #157
  - Extend support to Events and Livewire
  - Extend defining hasX by paths rather than individual file names or classes (cf. discoverMigrations).
    This avoids the need to list each item individually,
    allowing you to simply specify a path from which all files will be loaded/published.
  - Allow setting alternative paths to standard ones for all hasX.
  - Make Package->method() names consistent hasXByClass/hasXByName/hasXByPath etc.
  - Provide comprehensive validations for files, paths, classes etc. existing and exceptions where they don't.
  - Provide full backwards compatibility for previous versions
  - Switch test cases from Pest/PHPunit hybrid using the PHPunit Assertion API to full Pest Expactation API

### New Contributors

* @Sophist-UK made their first contribution in https://github.com/spatie/laravel-package-tools/pull/158

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.19.0...1.20.0

## 1.19.0 - 2025-02-06

### What's Changed

* Laravel 12 Support by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/160
* Ignore .phpunit.cache by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/161

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.18.3...1.19.0

## 1.18.3 - 2025-01-22

- avoid method name collisions

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.18.2...1.18.3

## 1.18.2 - 2025-01-20

### What's Changed

* General readability/extendability improvements by @stuart-elliott in https://github.com/spatie/laravel-package-tools/pull/157
* Remove breaking change of previous version

### New Contributors

* @stuart-elliott made their first contribution in https://github.com/spatie/laravel-package-tools/pull/157

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.18.0...1.18.2

## 1.18.1 - 2025-01-20

### What's Changed

* General readability/extendability improvements by @stuart-elliott in https://github.com/spatie/laravel-package-tools/pull/157

### New Contributors

* @stuart-elliott made their first contribution in https://github.com/spatie/laravel-package-tools/pull/157

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.18.0...1.18.1

## 1.18.0 - 2024-12-30

### What's Changed

* feature: discover migrations by @joelbutcher in https://github.com/spatie/laravel-package-tools/pull/153

### New Contributors

* @joelbutcher made their first contribution in https://github.com/spatie/laravel-package-tools/pull/153

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.17.0...1.18.0

## 1.17.0 - 2024-12-09

### What's Changed

* Support Laravel 11 development by @Riley19280 in https://github.com/spatie/laravel-package-tools/pull/146

### New Contributors

* @Riley19280 made their first contribution in https://github.com/spatie/laravel-package-tools/pull/146

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.6...1.17.0

## 1.16.6 - 2024-11-18

### What's Changed

* Fix implicit nullable deprecation notice by @mokhosh in https://github.com/spatie/laravel-package-tools/pull/150

### New Contributors

* @mokhosh made their first contribution in https://github.com/spatie/laravel-package-tools/pull/150

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.5...1.16.6

## 1.16.5 - 2024-08-27

### What's Changed

* Avoid bump on every menor release by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/132
* Update InstallCommand.php by @gaetan-hexadog in https://github.com/spatie/laravel-package-tools/pull/140

### New Contributors

* @gaetan-hexadog made their first contribution in https://github.com/spatie/laravel-package-tools/pull/140

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.4...1.16.5

## 1.16.4 - 2024-03-20

### What's Changed

* fixed #128 - check if l11 with new skeleton is used by @jetwes in https://github.com/spatie/laravel-package-tools/pull/129

### New Contributors

* @jetwes made their first contribution in https://github.com/spatie/laravel-package-tools/pull/129

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.3...1.16.4

## 1.16.3 - 2024-03-07

### What's Changed

* handle relative path in migration file exists check by @mvenghaus in https://github.com/spatie/laravel-package-tools/pull/127

### New Contributors

* @mvenghaus made their first contribution in https://github.com/spatie/laravel-package-tools/pull/127

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.2...1.16.3

## 1.16.2 - 2024-01-11

### What's Changed

* Bump actions/checkout from 3 to 4 by @dependabot in https://github.com/spatie/laravel-package-tools/pull/107
* Update README.md by @kgrzelak in https://github.com/spatie/laravel-package-tools/pull/109
* Apply the shorten null coalescing operator by @peter279k in https://github.com/spatie/laravel-package-tools/pull/111
* Allow Laravel 11 by @TomasVotruba in https://github.com/spatie/laravel-package-tools/pull/117

### New Contributors

* @kgrzelak made their first contribution in https://github.com/spatie/laravel-package-tools/pull/109
* @peter279k made their first contribution in https://github.com/spatie/laravel-package-tools/pull/111
* @TomasVotruba made their first contribution in https://github.com/spatie/laravel-package-tools/pull/117

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.1...1.16.2

## 1.16.1 - 2023-08-23

### What's Changed

- updating readme by @ArielMejiaDev in https://github.com/spatie/laravel-package-tools/pull/104
- Enable publishing any tag name with the install command by @misenhower in https://github.com/spatie/laravel-package-tools/pull/105

### New Contributors

- @misenhower made their first contribution in https://github.com/spatie/laravel-package-tools/pull/105

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.16.0...1.16.1

## 1.16.0 - 2023-08-09

### What's Changed

- add inertia components publish option by @ArielMejiaDev in https://github.com/spatie/laravel-package-tools/pull/103

### New Contributors

- @ArielMejiaDev made their first contribution in https://github.com/spatie/laravel-package-tools/pull/103

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.15.0...1.16.0

## 1.15.0 - 2023-04-27

### What's Changed

- Specify commands that will not be available on http calls by @systemsolutionweb in https://github.com/spatie/laravel-package-tools/pull/89

### New Contributors

- @systemsolutionweb made their first contribution in https://github.com/spatie/laravel-package-tools/pull/89

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.14.3...1.15.0

## 1.14.3 - 2023-04-25

### What's Changed

- Update README.md by @bishwajitcadhikary in https://github.com/spatie/laravel-package-tools/pull/97
- Bump dependabot/fetch-metadata from 1.3.6 to 1.4.0 by @dependabot in https://github.com/spatie/laravel-package-tools/pull/98
- Fix install command on Laravel 10.x breaking change by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/99

### New Contributors

- @bishwajitcadhikary made their first contribution in https://github.com/spatie/laravel-package-tools/pull/97

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.14.2...1.14.3

## 1.14.2 - 2023-03-14

### What's Changed

- Removal of publishable service provider typo by @peterfox in https://github.com/spatie/laravel-package-tools/pull/83
- Bump dependabot/fetch-metadata from 1.3.5 to 1.3.6 by @dependabot in https://github.com/spatie/laravel-package-tools/pull/84
- Enable publishing assets from the install command. by @DanielDarrenJones in https://github.com/spatie/laravel-package-tools/pull/86

### New Contributors

- @peterfox made their first contribution in https://github.com/spatie/laravel-package-tools/pull/83
- @DanielDarrenJones made their first contribution in https://github.com/spatie/laravel-package-tools/pull/86

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.14.1...1.14.2

## 1.14.1 - 2023-01-27

### What's Changed

- Refactor Package methods, changing return type to `static`, in order to allow Package extension per project by @GeoSot in https://github.com/spatie/laravel-package-tools/pull/82

### New Contributors

- @GeoSot made their first contribution in https://github.com/spatie/laravel-package-tools/pull/82

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.14.0...1.14.1

## 1.14.0 - 2023-01-10

### What's Changed

- Laravel 10 ✨  by @Nielsvanpach in https://github.com/spatie/laravel-package-tools/pull/81

### New Contributors

- @Nielsvanpach made their first contribution in https://github.com/spatie/laravel-package-tools/pull/81

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.13.9...1.14.0

## 1.1.39 - 2023-01-10

- added support for L10

## 1.13.8 - 2022-12-20

### What's Changed

- Fix for publishing view files that has its custom namespace by @askdkc in https://github.com/spatie/laravel-package-tools/pull/69
- PHP 8.2 Build by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/70
- Fix missing semicolon in readme by @howdu in https://github.com/spatie/laravel-package-tools/pull/71
- Refactor tests to pest by @AyoobMH in https://github.com/spatie/laravel-package-tools/pull/73
- View Components publish has a bug by @mrlinnth in https://github.com/spatie/laravel-package-tools/pull/72
- Add Dependabot Automation by @patinthehat in https://github.com/spatie/laravel-package-tools/pull/75
- Add PHP 8.2 Support by @patinthehat in https://github.com/spatie/laravel-package-tools/pull/77
- Update Dependabot Automation by @patinthehat in https://github.com/spatie/laravel-package-tools/pull/78

### New Contributors

- @askdkc made their first contribution in https://github.com/spatie/laravel-package-tools/pull/69
- @howdu made their first contribution in https://github.com/spatie/laravel-package-tools/pull/71
- @AyoobMH made their first contribution in https://github.com/spatie/laravel-package-tools/pull/73
- @mrlinnth made their first contribution in https://github.com/spatie/laravel-package-tools/pull/72

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.13.5...1.13.8

## 1.13.7 - 2022-11-15

### What's Changed

- PHP 8.2 Build by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/70
- Fix missing semicolon in readme by @howdu in https://github.com/spatie/laravel-package-tools/pull/71
- Refactor tests to pest by @AyoobMH in https://github.com/spatie/laravel-package-tools/pull/73
- View Components publish has a bug by @mrlinnth in https://github.com/spatie/laravel-package-tools/pull/72

### New Contributors

- @howdu made their first contribution in https://github.com/spatie/laravel-package-tools/pull/71
- @AyoobMH made their first contribution in https://github.com/spatie/laravel-package-tools/pull/73
- @mrlinnth made their first contribution in https://github.com/spatie/laravel-package-tools/pull/72

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.13.6...1.13.7

## 1.13.6 - 2022-10-11

### What's Changed

- Fix for publishing view files that has its custom namespace by @askdkc in https://github.com/spatie/laravel-package-tools/pull/69

### New Contributors

- @askdkc made their first contribution in https://github.com/spatie/laravel-package-tools/pull/69

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.13.5...1.13.6

## 1.13.5 - 2022-09-07

- improve colours of install command

## 1.13.4 - 2022-09-07

- remove dump statement

## 1.13.3 - 2022-09-07

- hide install command

## 1.13.2 - 2022-09-07

- improvements to install command

## 1.13.1 - 2022-09-07

- add `askToRunMigrations`

## 1.13.0 - 2022-09-07

### What's Changed

- Add install command by @freekmurze in https://github.com/spatie/laravel-package-tools/pull/64
- Drop support for PHP 7, anything below Laravel 8

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.12.1...1.13.0

## 1.12.1 - 2022-06-28

- add `newPackage` method

## 1.12.0 - 2022-06-19

### What's Changed

- Update .gitattributes by @angeljqv in https://github.com/spatie/laravel-package-tools/pull/53
- [PHP 8.2] Fix `${var}` string interpolation deprecation by @Ayesh in https://github.com/spatie/laravel-package-tools/pull/57
- Allow running of migrations by @riasvdv in https://github.com/spatie/laravel-package-tools/pull/56

### New Contributors

- @angeljqv made their first contribution in https://github.com/spatie/laravel-package-tools/pull/53
- @Ayesh made their first contribution in https://github.com/spatie/laravel-package-tools/pull/57
- @riasvdv made their first contribution in https://github.com/spatie/laravel-package-tools/pull/56

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.11.3...1.12.0

## 1.11.3 - 2022-03-15

## What's Changed

- Use lang_path() when available by @zupolgec in https://github.com/spatie/laravel-package-tools/pull/52

## New Contributors

- @zupolgec made their first contribution in https://github.com/spatie/laravel-package-tools/pull/52

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.11.2...1.11.3

## 1.11.2 - 2022-02-22

## What's Changed

- Laravel 9 lang folder location by @voicecode-bv in https://github.com/spatie/laravel-package-tools/pull/48

## New Contributors

- @voicecode-bv made their first contribution in https://github.com/spatie/laravel-package-tools/pull/48

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.11.1...1.11.2

## 1.11.1 - 2022-02-16

## What's Changed

- Support for non-stubbed migrations by @chillbram in https://github.com/spatie/laravel-package-tools/pull/50

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.11.0...1.11.1

## 1.11.0 - 2022-01-11

## What's Changed

- Correct Blade view components folder in documentation by @chillbram in https://github.com/spatie/laravel-package-tools/pull/47
- Remove Database\Factories from psr-4 by @bastien-phi in https://github.com/spatie/laravel-package-tools/pull/43
- Allow Laravel 9

## New Contributors

- @chillbram made their first contribution in https://github.com/spatie/laravel-package-tools/pull/47
- @bastien-phi made their first contribution in https://github.com/spatie/laravel-package-tools/pull/43

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.10.0...1.11.0

## 1.10.0 - 2021-12-18

## What's Changed

- Corrected error in hasViewComponents() docs... by @telkins in https://github.com/spatie/laravel-package-tools/pull/40
- Update .gitattributes by @erikn69 in https://github.com/spatie/laravel-package-tools/pull/44
- Add ability to customise view namespace by @freekmurze in https://github.com/spatie/laravel-package-tools/pull/45

## New Contributors

- @telkins made their first contribution in https://github.com/spatie/laravel-package-tools/pull/40
- @erikn69 made their first contribution in https://github.com/spatie/laravel-package-tools/pull/44
- @freekmurze made their first contribution in https://github.com/spatie/laravel-package-tools/pull/45

**Full Changelog**: https://github.com/spatie/laravel-package-tools/compare/1.9.2...1.10.0

## 1.9.2 - 2021-09-021

- don't install mockery by default

## 1.9.1 - 2021-09-20

- allow to re-publish migrations via artisan --force (#37)

## 1.9.0 - 2021-05-23

- add support for multiple config files

## 1.8.0 - 2021-05-22

- add support for JSON translations (#31)

## 1.7.0 - 2021-05-06

- add support to migrations in folders (#30)

## 1.6.3 - 2021-04-27

- fix migration file names when copying them (#28)

## 1.6.2 - 2021-03-25

- use Carbon::now() for Lumen compatibility. (#26)

## 1.6.1 - 2021-03-16

- execute command in context of the app (#23)

## 1.6.0 - 2021-03-12

- add support for view composers & shared view data (#22)

## 1.5.0 - 2021-03-10

- add support for Blade view components

## 1.4.3 - 2021-03-10

- use package shortname for publishing

## 1.4.2 - 2021-03-05

- fix publishing views (#15)

## 1.4.1 - 2021-03-04

- ensure unique timestamp on migration publish (#14)

## 1.4.0 - 2021-02-15

- allows parameters for setup methods to be passed in as a spread array (#11)

## 1.3.1 - 2021-02-02

- fix `migrationFileExists` (#7)

## 1.3.0 - 2021-01-28

- add `hasRoute`

## 1.2.3 - 2021-01-27

- fix migration file extension when publishing from Package (#3)

## 1.2.2 - 2021-01-27

- use short package name to register views

## 1.2.1 - 2021-01-27

- fix `hasMigrations`
- make `register` and `boot` chainable

## 1.2.0 - 2021-01-25

- add `hasAssets`

## 1.1.0 - 2021-01-25

- add `hasTranslations`

## 1.0.2 - 2021-01-25

- remove unneeded dependency

## 1.0.1 - 2021-01-25

- add support for Laravel 7

## 1.0.0 - 2021-01-25

- initial release
