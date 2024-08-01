<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Rules\{DateRule, RequiredRule, EmailRule, NameRule, PassRule, PhoneRule, SelectRule};
use Framework\Rules\Subject_rules\ClassNameRule;
use Framework\Rules\Subject_rules\SubjectCodeRule;
use Framework\Rules\Subject_rules\SubjectNameRule;
use Framework\Rules\Subject_rules\SubjectTeacherNameRule;
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
        $this->validator->add('subject_name', new SubjectNameRule());
        $this->validator->add('subject_teacher_name', new SubjectTeacherNameRule());
        $this->validator->add('standard_names', new ClassNameRule());
        $this->validator->add('sub_code', new SubjectCodeRule());
        $this->validator->add('select', new SelectRule());
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

        $fields = [
            'email' => ['required', 'email'],
            'name' => ['required', 'name'],
            'phone' => ['required', 'phone'],
            'department' => ['required'],
            'password' => ['pass'],
        ];

        if ($data['password'] == '') {
            unset($fields['password']);
        }

        $this->validator->validate($data, $fields);
    }

    public function validate_subject(array $data)
    {
        $fields = [
            'sub_name' => ['required', 'subject_name'],
            'sub_code' => ['required', 'sub_code']
        ];
        $this->validator->validate($data, $fields);
    }

    public function validate_standards(array $data)
    {
        $fields = [
            'std_name' => ['required'],
            'selected_teachers' => ['select'],
            'selected_subjects' => ['select'],
        ];
        $this->validator->validate($data, $fields);
    }
}
