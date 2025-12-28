<?php

declare(strict_types=1);

namespace Avik\Essence\Support;

use JsonException;

final class Json
{
    public static function encode(mixed $value, int $options = 0, int $depth = 512): string
    {
        return json_encode($value, $options | JSON_THROW_ON_ERROR, $depth);
    }

    public static function decode(string $json, bool $assoc = true, int $depth = 512, int $options = 0): mixed
    {
        return json_decode($json, $assoc, $depth, $options | JSON_THROW_ON_ERROR);
    }

    public static function isValid(string $json): bool
    {
        try {
            static::decode($json);
            return true;
        } catch (JsonException $e) {
            return false;
        }
    }

    public static function pretty(mixed $value): string
    {
        return static::encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
