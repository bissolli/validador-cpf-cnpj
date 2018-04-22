<?php

namespace Bissolli\ValidadorCpfCnpj;

class CPF extends DocumentoAbstract
{
    /**
     * Invalid numbers
     *
     * @var string
     */
    protected $blacklist = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999'
    ];

    /**
     * Check if it is a valid CPF number
     *
     * @return bool|string
     */
    public function isValid()
    {
        // Check the size
        if (strlen($this->value) != 11)
            return false;

        // Check if it is blacklisted
        if (in_array($this->value, $this->blacklist))
            return false;

        // Validate first check digit
        for ($i = 0, $j = 10, $sum = 0; $i < 9; $i++, $j--)
            $sum += $this->value{$i} * $j;

        $result = $sum % 11;

        if ($this->value{9} != ($result < 2 ? 0 : 11 - $result))
            return false;

        // Validate first second digit
        for ($i = 0, $j = 11, $sum = 0; $i < 10; $i++, $j--)
            $sum += $this->value{$i} * $j;

        $result = $sum % 11;

        return $this->value{10} == ($result < 2 ? 0 : 11 - $result);
    }

    /**
     * Format CPF
     *
     * @return string
     */
    public function format()
    {
        if (!$this->isValid())
            return false;

        // Format ###.###.###-##
        $result  = substr($this->value, 0, 3) . '.';
        $result .= substr($this->value, 3, 3) . '.';
        $result .= substr($this->value, 6, 3) . '-';
        $result .= substr($this->value, 9, 2) . '';

        return $result;
    }
}
