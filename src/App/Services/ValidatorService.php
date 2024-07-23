<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Rules\{DateRule, RequiredRule, EmailRule, NameRule, PassRule, PhoneRule};
use Framework\Validator;

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add('required', new RequiredRule());
        $this->validator->add('email', new EmailRule());
        $this->validator->add('pass', new PassRule());
        $this->validator->add('phone', new PhoneRule());
        $this->validator->add('date', new DateRule());
        $this->validator->add('name', new NameRule());
    }
    public function validate_login(array $data)
    {

        // dd($data);
        $this->validator->validate($data, [
            'email' => ['required'],
            'password' => ['required']
        ]);
    }

    public function validate_register(array $data)
    {
        $this->validator->validate($data, [
            'email' => ['required', 'email'],
            'password' => ['required', 'pass'],
            'first_name' => ['required', 'name'],
            'last_name' => ['required', 'name'],
            'dob' => ['required', 'date'],
            'gender' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'phone']
        ]);
    }
    public function validate_profile(array $data)
    {
        $this->validator->validate($data, [
            'email' => ['required', 'email'],
            'name' => ['required', 'name'],
            'phone' => ['required', 'phone'],
            'department' => ['required'],
            'password' => ['required', 'pass'],
        ]);
    }
}
