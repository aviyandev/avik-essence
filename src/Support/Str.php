<?php

declare(strict_types=1);

namespace Avik\Essence\Support;

final class Str
{
    public static function startsWith(string $value, string $needle): bool
    {
        return str_starts_with($value, $needle);
    }

    public static function endsWith(string $value, string $needle): bool
    {
        return str_ends_with($value, $needle);
    }

    public static function contains(string $haystack, string|iterable $needles): bool
    {
        if (!is_iterable($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle !== '' && str_contains($haystack, $needle)) {
                return true;
            }
        }

        return false;
    }

    public static function lower(string $value): string
    {
        return mb_strtolower($value, 'UTF-8');
    }

    public static function upper(string $value): string
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    public static function limit(string $value, int $limit = 100, string $end = '...'): string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }

        return mb_strimwidth($value, 0, $limit, $end, 'UTF-8');
    }

    public static function slug(string $value, string $separator = '-'): string
    {
        $value = self::lower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', $separator, $value);
        return trim($value, $separator);
    }

    public static function random(int $length = 16): string
    {
        return bin2hex(random_bytes($length / 2));
    }

    public static function snake(string $value, string $delimiter = '_'): string
    {
        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));
            $value = self::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return $value;
    }

    public static function kebab(string $value): string
    {
        return self::snake($value, '-');
    }

    public static function camel(string $value): string
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value))));
    }

    public static function studly(string $value): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $value)));
    }

    public static function headline(string $value): string
    {
        $parts = explode(' ', $value);

        if (count($parts) > 1) {
            $parts = array_map([self::class, 'title'], $parts);
        } else {
            $parts = preg_split('/(?=[A-Z])|[-_]/', $value, -1, PREG_SPLIT_NO_EMPTY);
            $parts = array_map([self::class, 'title'], $parts);
        }

        return implode(' ', $parts);
    }

    public static function title(string $value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    public static function finish(string $value, string $cap): string
    {
        $quoted = preg_quote($cap, '/');

        return preg_replace('/(?:' . $quoted . ')+$/u', '', $value) . $cap;
    }

    public static function start(string $value, string $prefix): string
    {
        $quoted = preg_quote($prefix, '/');

        return $prefix . preg_replace('/^(?:' . $quoted . ')+/u', '', $value);
    }

    public static function after(string $subject, string $search): string
    {
        return $search === '' ? $subject : array_reverse(explode($search, $subject, 2))[0];
    }

    public static function before(string $subject, string $search): string
    {
        return $search === '' ? $subject : explode($search, $subject)[0];
    }
}
