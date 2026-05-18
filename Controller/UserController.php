<?php

namespace Controller;

use Service\AuthService;
use Validator\UserValidator;

class UserController
{
    private $authService;
    private $userValidator;


    public function __construct()
    {
        $this->authService = new AuthService();
        $this->userValidator = new UserValidator();
    }

    public function createUser(string $user_fullname, string $email, string $password): bool
    {
        return $this->authService->createUser($user_fullname, $email, $password);
    }

    public function login(string $email, string $password)
    {
        return $this->authService->login($email, $password);
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['id']);
    }

    public function getUserData(int $id): array
    {
        return $this->authService->getUserData($id);
    }

    public function checkUserByEmail(string $email): bool
    {
        return (bool) $this->authService->checkUserByEmail($email);
    }

    public function passwordMatch(string $password, string $confirmPassword) {
        return $this->userValidator->checkPasswordMatch($password, $confirmPassword);
    }

    public function passwordValidation(string $password) {
        return $this->userValidator->passwordValidation($password);
    }

}