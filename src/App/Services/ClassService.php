<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Rules\{DateRule, RequiredRule, EmailRule, NameRule, PassRule, PhoneRule};
use Framework\Rules\Subject_rules\ClassNameRule;
use Framework\Rules\Subject_rules\SubjectCodeRule;
use Framework\Rules\Subject_rules\SubjectNameRule;
use Framework\Rules\Subject_rules\SubjectTeacherNameRule;
use Framework\Validator;

class ClassService
{


    public function __construct(private Database $db)
    {
    }

    public function total_classes()
    {
        $query = "SELECT COUNT(*) FROM `classroom`";
        return (($this->db->query($query)->find())['COUNT(*)']);
    }
}