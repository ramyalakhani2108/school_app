<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class SelectRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {

        return !empty($formData[$field]);
    }
    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Please Select at least one option";
    }
}
