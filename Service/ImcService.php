<?php

namespace Service;

use Model\Imc;
use Validator\ImcValidator;

class ImcService
{
    private $imcModel;
    private $imcValidator;

    public function __construct()
    {
        $this->imcModel = new Imc();
        $this->imcValidator = new ImcValidator();
    }

    public function calculateImc(float $weight, float $height)
    {
        $this->imcValidator->validateFields($weight, $height);

        $imc = round($weight / ($height * $height), 2);

        return [
            "imc" => $imc,
            "BMIrange" => $this->classifyIMC($imc)
        ];
    }

    public function classifyIMC(float $imc): string
    {
        return match (true) {
            $imc < 18.5 => "Baixo peso",
            $imc >= 18.5 and $imc < 25 => "Peso normal",
            $imc >= 25 and $imc < 30 => "Sobrepeso",
            $imc >= 30 and $imc < 35 => "Obesidade grau I",
            $imc >= 35 and $imc < 40 => "Obesidade grau II",
            default => "Obesidade grau III"
        };
    }

    public function saveIMC(float $weight, float $height, float $IMCresult, int $id_user): bool
    {
        return $this->imcModel->createIMC($weight, $height, $IMCresult, $id_user);
    }

    public function showImcHistory($id_user)
    {
        $imcHistory = $this->imcModel->showIMCHistory($id_user);

        if (\count($imcHistory) < 2) {
            return [
                "message" => "Não há IMCs suficientes para calcular a variação.",
                'imcHistory' => []
            ];
        }

        $recentImcKey = array_key_last($imcHistory);
        $previousImcKey = $recentImcKey - 1;

        $recentImc = $imcHistory[$recentImcKey];
        $previousImc = $imcHistory[$previousImcKey];

        $variation = round($recentImc["result"] - $previousImc["result"], 2);

        return [
            "recentImc" => $recentImc["result"],
            "previousImc" => $previousImc["result"],
            "variation" => $variation,
            "imcHistory" => $imcHistory
        ];
    }

    public function deleteImc(int $id): bool
    {
        return $this->imcModel->deleteIMC($id);
    }
}