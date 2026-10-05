<?php
declare(strict_types=1);

// PSR-4 autoloader for the App\ namespace, so classes load on demand
// without a require_once per file. If Composer is installed, `composer
// dump-autoload` generates an equivalent loader from composer.json.
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require $file;
    }
});
