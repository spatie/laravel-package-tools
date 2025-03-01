<?php

/*
|--------------------------------------------------------------------------
| Generic Helpers
|--------------------------------------------------------------------------
*/

function is_before_laravel_9_44_0 (string $version): bool {
    return version_compare($version, '9.44.0') < 0;
}

function message_before_laravel_9_44_0 (): string {
    return 'Anonymous components not available until Laravel v9.44.0';
}

