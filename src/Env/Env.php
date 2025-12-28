<?php

declare(strict_types=1);

namespace Avik\Essence\Env;

final class Env
{
    protected static array $data = [];
    protected static bool $loaded = false;

    public static function load(string $path): void
    {
        if (self::$loaded || !is_file($path)) {
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Handle quoted values
            if (preg_match('/^"(.+)"$/', $value, $matches) || preg_match("/^'(.+)'$/", $value, $matches)) {
                $value = $matches[1];
            }

            $value = self::castValue($value);

            self::$data[$key] = $value;

            if (!isset($_ENV[$key])) {
                $_ENV[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::$data[$key]
            ?? $_ENV[$key]
            ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        self::$data[$key] = $value;
        $_ENV[$key] = $value;
    }

    protected static function castValue(string $value): mixed
    {
        return match (strtolower($value)) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'empty', '(empty)' => '',
            'null', '(null)' => null,
            default => $value,
        };
    }
}
