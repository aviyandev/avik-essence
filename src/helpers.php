<?php

declare(strict_types=1);

use Avik\Essence\Config\Config;
use Avik\Essence\Env\Env;
use Avik\Essence\Support\Collection;
use Avik\Essence\Support\Time;

if (!function_exists('env')) {
    /**
     * Get the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        return Env::get($key, $default);
    }
}

if (!function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config(array|string|null $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return Config::all();
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Config::set($k, $v);
            }
            return null;
        }

        return Config::get($key, $default);
    }
}

if (!function_exists('collect')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Avik\Essence\Support\Collection
     */
    function collect(mixed $value = []): Collection
    {
        return new Collection($value);
    }
}

if (!function_exists('now')) {
    /**
     * Create a new Time instance for the current time.
     *
     * @param  string|\DateTimeZone|null  $timezone
     * @return \Avik\Essence\Support\Time
     */
    function now(string|\DateTimeZone|null $timezone = null): Time
    {
        return Time::now($timezone);
    }
}
