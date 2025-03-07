<?php

/*
|--------------------------------------------------------------------------
| Generic Helpers
|--------------------------------------------------------------------------
*/

function is_before_laravel_version(string $actualVersion, string $minVersion): bool
{
    return version_compare($actualVersion, $minVersion) < 0;
}

function message_before_laravel_version(string $minVersion): string
{
    return 'LaravelPackageTools Functionality not available until Laravel v' . $minVersion;
}
