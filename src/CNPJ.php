<?php

namespace Bissolli\ValidadorCpfCnpj;

class CNPJ extends DocumentoAbstract
{
    /**
     * Invalid numbers
     *
     * @var string
     */
    protected $blacklist = [
        '00000000000000',
        '11111111111111',
        '22222222222222',
        '33333333333333',
        '44444444444444',
        '55555555555555',
        '66666666666666',
        '77777777777777',
        '88888888888888',
        '99999999999999'
    ];

    /**
     * Check if it is a valid CNPJ number
     *
     * @return bool|string
     */
    public function isValid()
    {
        // Check the size
        if (strlen($this->value) != 14)
            return false;

        // Check if it is blacklisted
        if (in_array($this->value, $this->blacklist))
            return false;

        // Validate first check digit
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $this->value{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $result = $sum % 11;

        if ($this->value{12} != ($result < 2 ? 0 : 11 - $result))
            return false;

        // Validate second check digit
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $this->value{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $result = $sum % 11;

        return $this->value{13} == ($result < 2 ? 0 : 11 - $result);
    }

    /**
     * Format CNPJ
     *
     * @return string
     */
    public function format()
    {
        if (!$this->isValid())
            return false;

        // Format ##.###.###/####-##
        $result  = substr($this->value, 0, 2) . '.';
        $result .= substr($this->value, 2, 3) . '.';
        $result .= substr($this->value, 5, 3) . '/';
        $result .= substr($this->value, 8, 4) . '-';
        $result .= substr($this->value, 12, 2) . '';

        return $result;
    }
}
