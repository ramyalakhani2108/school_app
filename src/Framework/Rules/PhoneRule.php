<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class PhoneRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        // Regular expression for basic phone number validation
        $phoneNumber = $formData[$field];
        $pattern = '/^\+?[0-9]{1,3}\s?[0-9]{3,}$/'; // Adjust this pattern as per your phone number format requirements

        return (bool) preg_match($pattern, $phoneNumber);
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid phone number format";
    }
}
