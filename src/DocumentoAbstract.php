<?php

namespace Bissolli\ValidadorCpfCnpj;

abstract class DocumentoAbstract
{
    /**
     * Value to be validated
     *
     * @var string
     */
    protected $value;

    /**
     * Create a new ValidaDocumento instance
     *
     * @param string $value
     */
    public function __construct($value = null)
    {
        if ($value) $this->setValue($value);
    }


    abstract public function isValid();
    abstract public function format();

    /**
     * Get class name without namespace
     *
     * @return string
     */
    public function getClassName()
    {
        return substr(strrchr(get_class($this), '\\'), 1);
    }

    /**
     * Get the raw value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the clean value
     *
     * @return self
     */
    public function setValue($value)
    {
        $this->value = (string) preg_replace('/[^0-9]/', '', $value);
        return $this;
    }
}
