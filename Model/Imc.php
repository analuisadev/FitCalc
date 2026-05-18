<?php

namespace Model;

use Model\Connection;

use PDO;
use PDOException;

class Imc
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function createIMC(float $weight, float $height, float $result, int $id_user): bool
    {
        try {
            $sql = "INSERT INTO imcs (weight, height, result, created_at, id_user) VALUES (:weight, :height, :result, NOW(), :id_user)";

            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":weight", $weight, PDO::PARAM_STR);
            $stmt->bindParam(":height", $height, PDO::PARAM_STR);
            $stmt->bindParam(":result", $result, PDO::PARAM_STR);
            $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao criar IMC: " . $error->getMessage());
            return false;
        }
    }

    public function showIMCHistory(int $id_user): array|bool
    {
        try {
            $sql = "SELECT * FROM imcs WHERE id_user = :id_user ORDER BY created_at ASC LIMIT 6";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id_user", $id_user, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $error) {
            error_log("Erro ao buscar histórico do IMC: " . $error->getMessage());
            return false;
        }
    }

    public function deleteIMC(int $id): bool
    {
        try {
            $sql = "DELETE FROM imcs WHERE id = :id";

            $stmt = $this->db->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao excluir IMC: " . $error->getMessage());
            return false;
        }
    }
}