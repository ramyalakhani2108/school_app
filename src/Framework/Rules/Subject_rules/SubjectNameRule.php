<?php

declare(strict_types=1);

namespace Framework\Rules\Subject_rules;

use Framework\Contracts\RuleInterface;

class SubjectNameRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        // Retrieve the subject name from the form data
        $subjectName = $formData[$field];

        // Check if the subject name is at least 4 characters long, alphanumeric or alphabetic, allows underscores and spaces,
        // but cannot be only digits or contain other special characters
        return strlen($subjectName) >= 4 && preg_match('/^(?!^\d+$)[a-zA-Z0-9_ ]+$/', $subjectName) === 1;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "The name must be at least 4 characters long, alphanumeric or alphabetic, may contain underscores and spaces, but cannot be only digits or contain other special characters.";
    }
}
