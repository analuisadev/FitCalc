<?php

namespace Validator;

class UserValidator
{
    public function checkPasswordMatch(string $password, string $confirmPassword): bool
    {
        return $password === $confirmPassword;
    }

    public function passwordValidation(string $password): bool
    {
        $pattern = '/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,33}$/';

        return (bool) preg_match($pattern, $password);
    }

    public function verifyUserEmail(string $email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return true;
    }

    public function verifyEmptyFields(string $user_fullname, string $email, string $password): bool
    {
        if (empty($user_fullname) or empty($email) or empty($password)) {
            return false;
        }

        return true;
    }
}