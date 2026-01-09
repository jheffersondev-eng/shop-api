<?php

namespace Src\Application\Support;

class DocumentHelper
{
    /**
     * Remove all special characters from a string.
     */
    public static function stripSpecialChars(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        // Normalize unicode and remove control chars
        $value = trim($value);

        // Remove everything that is not a letter, number or space
        $clean = preg_replace('/[^\p{L}\p{N} ]+/u', '', $value);

        // Collapse multiple spaces
        $clean = preg_replace('/\s+/', ' ', $clean);

        return $clean;
    }

    /**
     * Format a CPF (11 digits) or CNPJ (14 digits).
     */
    public static function formatCpfCnpj(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        // Keep only digits
        $digits = preg_replace('/\D+/', '', $value);

        if (strlen($digits) === 11) {
            // CPF: 000.000.000-00
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
        }

        if (strlen($digits) === 14) {
            // CNPJ: 00.000.000/0000-00
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $digits);
        }

        return $digits;
    }

    public static function validateDocument(string $document): bool
    {
        $document = self::stripSpecialChars($document);
        
        $len = strlen($document);

        if ($len === 11) {
            return self::validateCPF($document);
        }

        if ($len === 14) {
            return self::validateCNPJ($document);
        }

        return false;
    }

    private static function validateCPF(string $cpf): bool
    {
        // Rejeita sequências tipo 11111111111
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Primeiro dígito
        $soma = 0;
        $peso = 10;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * $peso;
            $peso--;
        }

        $d1 = ($soma * 10) % 11;
        if ($d1 == 10) $d1 = 0;

        if ($d1 != $cpf[9]) {
            return false;
        }

        // Segundo dígito
        $soma = 0;
        $peso = 11;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * $peso;
            $peso--;
        }

        $d2 = ($soma * 10) % 11;
        if ($d2 == 10) $d2 = 0;

        return $d2 == $cpf[10];
    }

    private static function validateCNPJ(string $cnpj): bool
    {
        // Rejeita sequências do tipo 00000000000000
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Pesos
        $pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        $pesos2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

        // Primeiro dígito
        $soma = 0;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $pesos1[$i];
        }

        $d1 = $soma % 11;
        $d1 = ($d1 < 2) ? 0 : 11 - $d1;

        if ($d1 != $cnpj[12]) {
            return false;
        }

        // Segundo dígito
        $soma = 0;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $pesos2[$i];
        }

        $d2 = $soma % 11;
        $d2 = ($d2 < 2) ? 0 : 11 - $d2;

        return $d2 == $cnpj[13];
    }
}
