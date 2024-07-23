<?php

declare(strict_types=1);

namespace Framework\Rules;

use DateTime;
use DateTimeZone;
use DateInterval;
use Framework\Contracts\RuleInterface;

class DateRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        // Ensure the date is in a format that can be parsed by DateTime
        $dateString = $formData[$field];
        $date = DateTime::createFromFormat('Y-m-d', $dateString);

        if (!$date) {
            return false; // Invalid date format
        }

        // Calculate the current date
        $now = new DateTime('now', new DateTimeZone('UTC'));

        // Calculate the maximum birth date for someone under 18 years old
        $maxUnder18BirthDate = (clone $now)->sub(new DateInterval('P18Y'));

        // Calculate the minimum birth date for someone older than 5 years
        $minOver5BirthDate = (clone $now)->sub(new DateInterval('P5Y'));
        // dd([$maxUnder18BirthDate, $now, $minOver5BirthDate]);

        // Compare the user's birth date with the calculated birth dates
        return $date > $maxUnder18BirthDate && $date < $minOver5BirthDate;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "You must be between 6 and 17 years old to register.";
    }
}
