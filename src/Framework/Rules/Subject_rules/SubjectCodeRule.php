<?php

declare(strict_types=1);

namespace Framework\Rules\Subject_rules;

use Framework\Contracts\RuleInterface;

class SubjectCodeRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        // Retrieve the subject code from the form data
        $subjectCode = $formData[$field];

        // Check if the subject code is at least 6 characters long
        if (strlen($subjectCode) < 6) {
            $this->errorMessage = "The subject code must be at least 6 characters long.";
            return false;
        }

        // Check if the subject code contains only alphabetic characters
        if (!preg_match('/^[a-z\dA-Z]+$/', $subjectCode)) {
            $this->errorMessage = "The subject code can only contain alphabetic characters and cannot include special characters or whitespace.";
            return false;
        }

        // Check if the subject code contains only digits
        if (preg_match('/^\d+$/', $subjectCode)) {
            $this->errorMessage = "The subject code cannot be composed entirely of digits.";
            return false;
        }

        // If all checks pass
        return true;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return $this->errorMessage ?? "The subject code is invalid.";
    }

    private $errorMessage;
}
