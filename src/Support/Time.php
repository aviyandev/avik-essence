<?php

declare(strict_types=1);

namespace Avik\Essence\Support;

use DateTimeImmutable;
use DateTimeZone;
use Exception;

class Time extends DateTimeImmutable
{
    public static function now(string|DateTimeZone|null $timezone = null): static
    {
        return new static('now', static::parseTimezone($timezone));
    }

    public static function parse(string $time, string|DateTimeZone|null $timezone = null): static
    {
        return new static($time, static::parseTimezone($timezone));
    }

    public static function create(
        int $year,
        int $month = 1,
        int $day = 1,
        int $hour = 0,
        int $minute = 0,
        int $second = 0,
        string|DateTimeZone|null $timezone = null
    ): static {
        $time = sprintf('%04d-%02d-%02d %02d:%02d:%02d', $year, $month, $day, $hour, $minute, $second);

        return static::parse($time, $timezone);
    }

    protected static function parseTimezone(string|DateTimeZone|null $timezone): ?DateTimeZone
    {
        if (is_string($timezone)) {
            return new DateTimeZone($timezone);
        }

        return $timezone;
    }

    public function formatDefault(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    public function toDateString(): string
    {
        return $this->format('Y-m-d');
    }

    public function toTimeString(): string
    {
        return $this->format('H:i:s');
    }

    public function addDays(int $days): static
    {
        return $this->modify("+$days days");
    }

    public function subDays(int $days): static
    {
        return $this->modify("-$days days");
    }

    public function addMonths(int $months): static
    {
        return $this->modify("+$months months");
    }

    public function subMonths(int $months): static
    {
        return $this->modify("-$months months");
    }

    public function addYears(int $years): static
    {
        return $this->modify("+$years years");
    }

    public function subYears(int $years): static
    {
        return $this->modify("-$years years");
    }

    public function isFuture(): bool
    {
        return $this > static::now($this->getTimezone());
    }

    public function isPast(): bool
    {
        return $this < static::now($this->getTimezone());
    }

    public function isToday(): bool
    {
        return $this->toDateString() === static::now($this->getTimezone())->toDateString();
    }

    public function __toString(): string
    {
        return $this->formatDefault();
    }
}
