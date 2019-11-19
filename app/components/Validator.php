<?php


namespace components;


use models\Member;

class Validator
{
    private $fields;
    private $required;
    private $maxLength;
    private $filter;
    private $errors = [];

    public function __construct($fields, $required, $maxLength, $filter)
    {
        $this->fields = $fields;
        $this->required = $required;
        $this->maxLength = $maxLength;
        $this->filter = $filter;
    }

    private function checkRequired()
    {
        if (!empty($this->required)) {
            foreach ($this->required as $field) {
                if (empty($this->fields[$field])) {
                    $field = ucfirst(str_replace('_', ' ', $field));
                    array_push($this->errors, $field . ' could not be empty');
                }
            }
        }
    }

    private function checkMaxLength()
    {
        if (!empty($this->maxLength)) {
            foreach ($this->maxLength as $field => $maxLength) {
                if (strlen($this->fields[$field]) > $maxLength) {
                    $field = ucfirst(str_replace('_', ' ', $field));
                    array_push($this->errors, "{$field} length could not be more than {$maxLength} symbols");
                }
            }
        }
    }

    private function checkFilter()
    {
        if (!empty($this->filter)) {
            foreach ($this->filter as $field => $rule) {

                if ($rule == 'date') {
                    $date = date_parse($this->fields[$field]);
                    if ($date["error_count"] != 0 || !checkdate($date["month"], $date["day"], $date["year"])) {
                        array_push($this->errors, "Date field is not correct");
                    }
                } elseif ($rule == 'email') {
                    if (Member::isEmailInUse($this->fields[$field])) {
                        array_push($this->errors, "Email is already in use");
                    }
                    if (!filter_var($this->fields['email'], FILTER_VALIDATE_EMAIL)) {
                        array_push($this->errors, "Email is not formatted correctly");
                    }
                } elseif ($rule == 'phone') {
                    $phone = preg_replace('~\D~', '', $this->fields[$field]);
                    if (strlen($phone) != 11) {
                        array_push($this->errors, "Phone number should be 11 digits");
                    }
                } elseif ($rule == 'photo') {
                    if ($_FILES["photo"]["type"] != "image/gif" &&
                        $_FILES["photo"]["type"] != "image/jpg" &&
                        $_FILES["photo"]["type"] != "image/jpeg" &&
                        $_FILES["photo"]["type"] != "image/png" &&
                        $_FILES["photo"]["type"] != "image/bmp" &&
                        !empty($_FILES["photo"]["type"])
                    ) {
                        array_push($this->errors, "Uploaded image extension can be only jpg, png, jpeg, bmp or gif");
                    }
                }

            }
        }
    }

    public function validate()
    {
        self::checkRequired();
        self::checkMaxLength();
        self::checkFilter();

        return $this->errors;
    }
}