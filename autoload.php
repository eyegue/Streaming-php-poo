<?php

spl_autoload_register(function (string $className): void {
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $className . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});
