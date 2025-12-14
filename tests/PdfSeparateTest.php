<?php

namespace Escarter\PopplerPhp\Tests;

use Escarter\PopplerPhp\Exceptions\PdfNotFound;
use Escarter\PopplerPhp\PdfSeparate;
use PHPUnit\Framework\TestCase;

class PdfSeparateTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated_with_default_bin_path()
    {
        $pdfSeparate = new PdfSeparate();
        $this->assertInstanceOf(PdfSeparate::class, $pdfSeparate);
    }

    /** @test */
    public function it_can_be_instantiated_with_custom_bin_path()
    {
        $pdfSeparate = new PdfSeparate('/custom/path/pdfseparate');
        $this->assertInstanceOf(PdfSeparate::class, $pdfSeparate);
    }

    /** @test */
    public function it_can_set_pdf_file()
    {
        $pdfSeparate = new PdfSeparate();
        $result = $pdfSeparate->setPdf(__FILE__); // Use this test file as a test

        $this->assertSame($pdfSeparate, $result);
    }

    /** @test */
    public function it_can_set_destination()
    {
        $pdfSeparate = new PdfSeparate();
        $result = $pdfSeparate->setDestination('/tmp/test_output_%d.pdf');

        $this->assertSame($pdfSeparate, $result);
    }

    /** @test */
    public function it_throws_exception_for_nonexistent_pdf()
    {
        $this->expectException(PdfNotFound::class);
        $this->expectExceptionMessage('Could not read');

        $pdfSeparate = new PdfSeparate();
        $pdfSeparate->setPdf('/nonexistent/file.pdf');
    }

    /** @test */
    public function it_can_set_options_array()
    {
        $pdfSeparate = new PdfSeparate();
        $result = $pdfSeparate->setOptions(['-f', '1', '-l', '5']);

        $this->assertSame($pdfSeparate, $result);
    }

    /** @test */
    public function it_can_add_options_to_existing_options()
    {
        $pdfSeparate = new PdfSeparate();
        $pdfSeparate->setOptions(['-f', '1']);
        $result = $pdfSeparate->addOptions(['-l', '5']);

        $this->assertSame($pdfSeparate, $result);
    }

    /** @test */
    public function static_get_output_method_exists()
    {
        $this->assertTrue(method_exists(PdfSeparate::class, 'getOutput'));
    }

    /** @test */
    public function it_handles_options_with_values()
    {
        $pdfSeparate = new PdfSeparate();
        $result = $pdfSeparate->setOptions(['-f 1', '-l 5']);

        $this->assertSame($pdfSeparate, $result);
    }

    /** @test */
    public function it_handles_options_without_dashes()
    {
        $pdfSeparate = new PdfSeparate();
        $result = $pdfSeparate->setOptions(['f', '1', 'l', '5']);

        $this->assertSame($pdfSeparate, $result);
    }

    /** @test */
    public function split_method_exists()
    {
        $pdfSeparate = new PdfSeparate();
        $this->assertTrue(method_exists($pdfSeparate, 'split'));
    }

    /** @test */
    public function it_can_chain_methods()
    {
        $pdfSeparate = new PdfSeparate();
        $result = $pdfSeparate
            ->setPdf(__FILE__)
            ->setDestination('/tmp/test_%d.pdf')
            ->setOptions(['-f', '1']);

        $this->assertSame($pdfSeparate, $result);
    }
}
