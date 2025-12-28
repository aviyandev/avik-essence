<?php

declare(strict_types=1);

namespace Avik\Essence\Support;

use Exception;

final class File
{
    public static function exists(string $path): bool
    {
        return file_exists($path);
    }

    public static function get(string $path): string
    {
        if (!static::exists($path)) {
            throw new Exception("File does not exist: $path");
        }

        return file_get_contents($path);
    }

    public static function put(string $path, string $contents, bool $lock = false): int|bool
    {
        return file_put_contents($path, $contents, $lock ? LOCK_EX : 0);
    }

    public static function append(string $path, string $contents): int|bool
    {
        return file_put_contents($path, $contents, FILE_APPEND);
    }

    public static function delete(string|array $paths): bool
    {
        $paths = is_array($paths) ? $paths : func_get_args();

        $success = true;

        foreach ($paths as $path) {
            try {
                if (!@unlink($path)) {
                    $success = false;
                }
            } catch (Exception $e) {
                $success = false;
            }
        }

        return $success;
    }

    public static function move(string $path, string $target): bool
    {
        return rename($path, $target);
    }

    public static function copy(string $path, string $target): bool
    {
        return copy($path, $target);
    }

    public static function extension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    public static function name(string $path): string
    {
        return pathinfo($path, PATHINFO_FILENAME);
    }

    public static function basename(string $path): string
    {
        return pathinfo($path, PATHINFO_BASENAME);
    }

    public static function size(string $path): int
    {
        return filesize($path);
    }

    public static function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    public static function isFile(string $path): bool
    {
        return is_file($path);
    }

    public static function makeDirectory(string $path, int $mode = 0755, bool $recursive = true): bool
    {
        return mkdir($path, $mode, $recursive);
    }
}
