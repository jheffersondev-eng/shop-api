<?php

namespace Src\Application\Support;

class PhoneHelper
{
    /**
     * Keep only digits from phone string.
     * @param string|null $value
     * @return string
     */
    public static function normalize(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return preg_replace('/\\D+/', '', $value);
    }

    /**
     * Format phone number smartly for Brazilian phones.
     * Supports with or without country code (+55).
     * Examples:
     * - 5511999998888 -> +55 (11) 99999-8888
     * - 11999998888   -> (11) 99999-8888
     * - 1198888777    -> (11) 98888-7777
     * - 988887777     -> 98888-7777
     * - 88887777      -> 8888-7777
     * If length doesn't match expected patterns, returns digits only.
     *
     * @param string|null $value
     * @return string
     */
    /**
     * Format phone number smartly for Brazilian phones.
     * If $includeCountry is true and no country code is present, 
     * the formatted string will be prefixed with +55.
     *
     * @param string|null $value
     * @param bool $includeCountry
     * @return string
     */
    public static function format(?string $value, bool $includeCountry = false): string
    {
        $d = self::normalize($value);

        if ($d === '') {
            return '';
        }

        // with country code 55
        if (strlen($d) === 13 && substr($d, 0, 2) === '55') {
            $cc = '+55';
            $ddd = substr($d, 2, 2);
            $rest = substr($d, 4);
            return sprintf('%s (%s) %s', $cc, $ddd, self::formatLocalNumber($rest));
        }

        // with country code but different lengths (e.g., 12 -> 55 + 10 digits)
        if (strlen($d) === 12 && substr($d, 0, 2) === '55') {
            $cc = '+55';
            $ddd = substr($d, 2, 2);
            $rest = substr($d, 4);
            return sprintf('%s (%s) %s', $cc, $ddd, self::formatLocalNumber($rest));
        }

        // without country code
        if (strlen($d) === 11) {
            $ddd = substr($d, 0, 2);
            $rest = substr($d, 2);
            return sprintf('(%s) %s', $ddd, self::formatLocalNumber($rest));
        }

        if (strlen($d) === 10) {
            $ddd = substr($d, 0, 2);
            $rest = substr($d, 2);
            return sprintf('(%s) %s', $ddd, self::formatLocalNumber($rest));
        }

        if (strlen($d) === 9 || strlen($d) === 8) {
            return self::formatLocalNumber($d);
        }

        // unknown pattern: return digits
        $out = $d;

        if ($includeCountry) {
            // if digits look like DDD+local (10 or 11) or local (8/9) we add +55 prefix
            if (!empty($d) && substr($d, 0, 2) !== '55') {
                // format best-effort
                if (strlen($d) >= 8) {
                    $out = '+55 ' . $out;
                }
            }
        }

        return $out;
    }

    /**
     * Format local (no DDD) number of 8 or 9 digits: 9xxxx-xxxx or xxxx-xxxx
     * @param string $digits
     * @return string
     */
    protected static function formatLocalNumber(string $digits): string
    {
        $len = strlen($digits);
        if ($len === 9) {
            return preg_replace('/(\\d{5})(\\d{4})/', '$1-$2', $digits);
        }
        if ($len === 8) {
            return preg_replace('/(\\d{4})(\\d{4})/', '$1-$2', $digits);
        }

        // fallback split roughly
        if ($len > 4) {
            $first = substr($digits, 0, $len - 4);
            $last = substr($digits, -4);
            return $first . '-' . $last;
        }

        return $digits;
    }

    /**
     * Extract components: country (optional), ddd (optional), number (remaining digits)
     * @param string|null $value
     * @return array{country?:string, ddd?:string, number:string}
     */
    public static function extractComponents(?string $value): array
    {
        $d = self::normalize($value);
        $result = ['country' => '', 'ddd' => '', 'number' => ''];

        if ($d === '') {
            return $result;
        }

        if (substr($d, 0, 2) === '55') {
            $result['country'] = '55';
            $d = substr($d, 2);
        }

        if (strlen($d) >= 10) {
            $result['ddd'] = substr($d, 0, 2);
            $result['number'] = substr($d, 2);
            return $result;
        }

        // no DDD
        $result['number'] = $d;
        return $result;
    }

    /**
     * Detect if phone number is mobile (starts with 9 when including DDD) or is 9-digit local
     * @param string|null $value
     * @return bool
     */
    public static function isMobile(?string $value): bool
    {
        $components = self::extractComponents($value);
        $number = $components['number'] ?? '';
        if ($number === '') {
            return false;
        }

        // mobile in Brazil usually has 9 digits and starts with 9
        $digits = $number;
        if (strlen($digits) === 9 && $digits[0] === '9') {
            return true;
        }

        // with DDD and total length 11, number part 9 digits
        if (isset($components['ddd']) && $components['ddd'] !== '' && strlen($digits) === 9 && $digits[0] === '9') {
            return true;
        }

        return false;
    }
}
