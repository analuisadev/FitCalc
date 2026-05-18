<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }
    //Para o formulário de registro
    public function createUser(string $user_fullname, string $email, string $password, ?string $profilePhoto): bool
    {
        try {
            $sql = "INSERT INTO user (user_fullname, email, password, created_at, profile_photo) VALUES (:user_fullname, :email, :password, NOW(), :profile_photo)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":user_fullname", $user_fullname, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->bindParam(":profile_photo", $profilePhoto, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $error) {
            error_log("Erro ao registrar usuário: " . $error->getMessage());
            return false;
        }
    }
    //Para o header
    public function getUserInfo(int $id): array|bool
    {
        try {
            $sql = "SELECT user_fullname, email, profile_photo FROM user WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar informações do usuário: " . $error->getMessage());
            return false;
        }
    }
    //Para login e verificação de criação de e-mail que já existe
    public function getUserByEmail(string $email): array|bool
    {
        try {
            $sql = "SELECT * FROM user WHERE email = :email";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar e-mail do usuário: " . $error->getMessage());
            return false;
        }
    }
}