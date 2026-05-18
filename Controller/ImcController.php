<?php
//CRUD
namespace Controller;

use Service\ImcService;
use Validator\ImcValidator;

class ImcController
{
    private $imcService;
    private $imcValidator;
    public function __construct()
    {
        $this->imcService = new ImcService();
        $this->imcValidator = new ImcValidator();
    }

    public function getImc(float $weight, float $height): array
    {
        return $this->imcService->calculateImc($weight, $height);
    }

    public function getImcHistory(int $id_user): array
    {
        return $this->imcService->showImcHistory($id_user);
    }

    public function validateFields(float $weight, float $height): array|null
    {
        return $this->imcValidator->validateFields($weight, $height);
    }

    public function saveIMC(float $weight, float $height, float $IMCresult, int $id_user): bool {
        return $this->imcService->saveIMC($weight, $height, $IMCresult, $id_user);
    }
}
