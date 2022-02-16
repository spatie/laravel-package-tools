# Changelog

All notable changes to `laravel-package-tools` will be documented in this file.

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
