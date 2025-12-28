<?php

declare(strict_types=1);

namespace Avik\Essence\Config;

use Avik\Essence\Support\Arr;
use Avik\Seed\Contracts\Arrayable;

final class Repository implements Arrayable
{
    protected array $items = [];

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->items, $key, $default);
    }

    public function has(string $key): bool
    {
        return Arr::has($this->items, $key);
    }

    public function set(string $key, mixed $value): void
    {
        Arr::set($this->items, $key, $value);
    }

    public function forget(string $key): void
    {
        Arr::forget($this->items, $key);
    }

    public function all(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
