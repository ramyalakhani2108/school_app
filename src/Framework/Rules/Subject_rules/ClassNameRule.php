<?php

declare(strict_types=1);

namespace Framework\Rules\Subject_rules;

use Framework\Contracts\RuleInterface;

class ClassNameRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        // Retrieve the class names from the form data
        $classNames = $formData[$field];

        // Split the comma-separated values
        $classNamesArray = explode(',', $classNames);

        // Validate each value
        foreach ($classNamesArray as $name) {
            $name = trim($name); // Remove any leading/trailing spaces

            // Check if the name is at least 6 characters long
            if (strlen($name) < 6) {
                $this->errorMessage = "Each class name must be at least 6 characters long.";
                return false;
            }

            // Check if the name contains only alphanumeric characters
            if (!preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
                $this->errorMessage = "Each class name can only contain alphanumeric characters and cannot contain special characters.";
                return false;
            }
        }

        return true;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return $this->errorMessage ?? "The class names are invalid.";
    }

    private $errorMessage; // Holds the specific error message
}
