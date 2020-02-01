<?php

declare(strict_types=1);

namespace Bissolli\ValidadorCpfCnpj\Test;

use PHPUnit\Framework\TestCase;
use Bissolli\ValidadorCpfCnpj\Documento;

final class DocumentoTest extends TestCase
{
    /** @test */
    public function test_should_identify_as_cpf(): void
    {
        $document = new Documento('11122233343');

        $this->assertEquals($document->getType(), "CPF");
    }

    /** @test */
    public function test_should_identify_as_cpnj(): void
    {
        $document = new Documento('11222333456720');

        $this->assertEquals($document->getType(), "CNPJ");
    }

    /** @test */
    public function test_should_throw_error_when_a_not_valid_number_is_provided(): void
    {
        $document = new Documento('1720');
        
        $this->assertEquals($document->isValid(), false);
    }

    /** @test */
    public function test_should_accept_formatted_values(): void
    {
        $document = new Documento('111.234.567-98');

        $this->assertEquals($document->getType(), "CPF");
    }

    /** @test */
    public function test_should_return_formatted_value(): void
    {
        $document = new Documento("33000167000101");

        $this->assertEquals($document->format(), "33.000.167/0001-01");
    }

    /** @test */
    public function test_sbhoudl_return_raw_value(): void
    {
        $document = new Documento("123.456.789-01");

        $this->assertEquals($document->getValue(), "12345678901");
    }
}
