<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class NameRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        // Retrieve the name from the form data
        $name = $formData[$field];

        // Check if the name is between 3 and 50 characters long and contains only alphabetic characters
        return preg_match('/^[a-zA-Z]{3,50}$/', $name) === 1;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "The name must be between 3 and 50 characters long and contain only alphabetic characters without spaces or special characters.";
    }
}
