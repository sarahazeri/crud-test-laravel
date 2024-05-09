<?php

namespace App\Http\Rules;

use Closure;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberValidationRule
{
    public function validate($attribute, $value, Closure $fail)
    {
        if (!$this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }

    public function passes($attribute, $value)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumber = $phoneUtil->parse($value, 'ZZ');
            return $phoneUtil->isValidNumber($phoneNumber);
        } catch (\libphonenumber\NumberParseException $e) {
            return false;
        }
    }

    public function message()
    {
        return 'The :attribute is not a valid phone number.';
    }
}
