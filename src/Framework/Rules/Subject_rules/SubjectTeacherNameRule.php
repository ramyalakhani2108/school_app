<?php

declare(strict_types=1);

namespace Framework\Rules\Subject_rules;

use Framework\Contracts\RuleInterface;

class SubjectTeacherNameRule implements RuleInterface
{
    private $errorMessage; // Holds the specific error message

    public function validate(array $formData, string $field, array $params): bool
    {
        // Retrieve the teacher names from the form data
        $teacherNames = $formData[$field];

        // Split the comma-separated values
        $teacherNamesArray = explode(',', $teacherNames);

        // Validate each value
        foreach ($teacherNamesArray as $name) {
            $name = trim($name); // Remove any leading/trailing spaces

            // Check if the name is greater than 2 characters long
            if (strlen($name) <= 2) {
                $this->errorMessage = "Each teacher name must be greater than 2 characters long.";
                return false;
            }

            // Check if the name contains only alphabetic characters and no whitespace or special characters
            if (!preg_match('/^[a-zA-Z]+$/', $name)) {
                $this->errorMessage = "Each teacher name can only contain alphabetic characters and cannot contain whitespace or special characters.";
                return false;
            }
        }

        return true;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return $this->errorMessage ?? "The teacher names are invalid.";
    }
}
