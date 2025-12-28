<?php

declare(strict_types=1);

namespace Avik\Essence\Support;

final class Path
{
    public static function join(string ...$parts): string
    {
        return preg_replace('#/+#', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $parts));
    }

    public static function normalize(string $path): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    public static function isAbsolute(string $path): bool
    {
        return (bool) preg_match('#^([a-zA-Z]:\\\\|/)#', $path);
    }
}
