<?php

namespace Service;

use Model\User;
use Validator\UserValidator;
use Helper\FileHelper;

class AuthService
{
    private $userModel;
    private $userValidator;
    private $fileHelper;

    public function __construct()
    {
        $this->userModel = new User();
        $this->userValidator = new UserValidator();
        $this->fileHelper = new FileHelper();
    }

    public function createUser(string $user_fullname, string $email, string $password): bool
    {

        $this->userValidator->verifyEmptyFields($user_fullname, $email, $password);
        $this->userValidator->verifyUserEmail($email);
        $this->userValidator->passwordValidation($password);

        $photoFileName = null;
        $profilePhoto = $_FILES['profilePhoto'] ?? null;

        if ($profilePhoto && $profilePhoto['error'] !== UPLOAD_ERR_NO_FILE) {
            $photoFileName = $this->fileHelper->saveProfilePhoto($profilePhoto);
            if ($photoFileName === false)
                return false;
        }

        $hashedPassword = $this->hashPassword($password);

        return $this->userModel->createUser($user_fullname, $email, $hashedPassword, $photoFileName);
    }


    public function login(string $email, string $password)
    {
        $user = $this->userModel->getUserByEmail($email);

        if (!$user or !password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['id'] = $user['id'];
        $_SESSION['user_fullname'] = $user['user_fullname'];
        $_SESSION['email'] = $user['email'];

        return true;
    }

    public function getUserData(int $id): array
    {
        return $this->userModel->getUserInfo($id);
    }

    public function checkUserByEmail(string $email): bool
    {
        return (bool) $this->userModel->getUserByEmail($email);
    }
   
    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID, [
            'memory_cost' => 1 << 17,
            'time_cost' => 4,
            "threads" => 2
        ]);
    }

}