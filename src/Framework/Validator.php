<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];
    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $data, array $fields)
    {
        $errors = [];

        foreach ($fields as $field_name => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];

                if (str_contains($rule, ':')) {

                    [$rule, $ruleParams] = explode(':', $rule);

                    $ruleParams = explode(',', $ruleParams);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($data, $field_name, $ruleParams)) {
                    continue;
                }
                $errors[$field_name][] = $ruleValidator->getMessage($data, $field_name, $ruleParams);
            }
        }

        if (count($errors)) {

            throw new ValidationException($errors);
        }
    }
}
