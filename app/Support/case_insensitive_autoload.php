<?php
// Case-insensitive autoloader for App\Models namespace.
// This helps loading model classes when filenames' case doesn't match class names
// (useful for legacy repos on case-sensitive filesystems during development).

spl_autoload_register(function (string $class) {
    $prefix = 'App\\Models\\';

    // only handle App\\Models\\ classes
    if (strpos($class, $prefix) !== 0) {
        return;
    }

    // class name relative to App\\Models\\ (may include sub-namespaces)
    $relative = substr($class, strlen($prefix));
    if ($relative === '') {
        return;
    }

    $parts = explode('\\', $relative);
    $classFile = array_pop($parts) . '.php';

    $baseDir = __DIR__ . '/../Models';
    if (!is_dir($baseDir)) {
        return;
    }

    // iterate all files under app/Models and match filename case-insensitively
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($it as $file) {
        if (strcasecmp($file->getFilename(), $classFile) === 0) {
            require_once $file->getPathname();
            return;
        }
    }
});
