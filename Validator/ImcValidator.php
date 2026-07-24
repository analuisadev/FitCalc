<?php

namespace Validator;

class ImcValidator
{
    private function verifyNegativeNumbers(float $weight, float $height): array|null
    {
        if ($weight < 0 || $height < 0) {
            return [
                "imc" => null,
                "BMIrange" => "O peso e a altura não podem ser valores negativos."
            ];
        }

        return null;
    }

    private function verifyZeroValues(float $weight, float $height): array|null
    {
        if ($weight == 0 || $height == 0) {
            return [
                "imc" => null,
                "BMIrange" => "Os valores informados devem ser maiores do que zero."
            ];
        }

        return null;
    }

    public function validateFields(float $weight, float $height): array|null
    {
        $negativeValidation = $this->verifyNegativeNumbers($weight, $height);

        if ($negativeValidation !== null) {
            return $negativeValidation;
        }

        $zeroValidation = $this->verifyZeroValues($weight, $height);
        if ($zeroValidation !== null) {
            return $zeroValidation;
        }
        return null;
    }
}