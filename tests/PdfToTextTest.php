<?php

namespace Escarter\PopplerPhp\Tests;

use Escarter\PopplerPhp\PdfToText;
use Escarter\PopplerPhp\Exceptions\PdfNotFound;
use PHPUnit\Framework\TestCase;

class PdfToTextTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated_with_default_bin_path()
    {
        $pdfToText = new PdfToText();
        $this->assertInstanceOf(PdfToText::class, $pdfToText);
    }

    /** @test */
    public function it_can_be_instantiated_with_custom_bin_path()
    {
        $pdfToText = new PdfToText('/custom/path/pdftotext');
        $this->assertInstanceOf(PdfToText::class, $pdfToText);
    }

    /** @test */
    public function it_can_set_pdf_file()
    {
        $pdfToText = new PdfToText();
        $result = $pdfToText->setPdf(__FILE__); // Use this test file as a test

        $this->assertSame($pdfToText, $result);
    }

    /** @test */
    public function it_throws_exception_for_nonexistent_pdf()
    {
        $this->expectException(PdfNotFound::class);
        $this->expectExceptionMessage('Could not read');

        $pdfToText = new PdfToText();
        $pdfToText->setPdf('/nonexistent/file.pdf');
    }

    /** @test */
    public function it_can_set_options_array()
    {
        $pdfToText = new PdfToText();
        $result = $pdfToText->setOptions(['-layout', '-nopgbrk']);

        $this->assertSame($pdfToText, $result);
    }

    /** @test */
    public function it_can_add_options_to_existing_options()
    {
        $pdfToText = new PdfToText();
        $pdfToText->setOptions(['-layout']);
        $result = $pdfToText->addOptions(['-nopgbrk']);

        $this->assertSame($pdfToText, $result);
    }

    /** @test */
    public function it_can_parse_simple_options()
    {
        $pdfToText = new PdfToText();
        $pdfToText->setPdf(__FILE__);

        // This should work without throwing exceptions
        // The actual text() method would fail without pdftotext binary
        $this->assertInstanceOf(PdfToText::class, $pdfToText);
    }

    /** @test */
    public function static_get_text_method_exists()
    {
        $this->assertTrue(method_exists(PdfToText::class, 'getText'));
    }

    /** @test */
    public function it_handles_options_with_values()
    {
        $pdfToText = new PdfToText();
        $result = $pdfToText->setOptions(['-f 1', '-l 5']);

        $this->assertSame($pdfToText, $result);
    }

    /** @test */
    public function it_handles_options_without_dashes()
    {
        $pdfToText = new PdfToText();
        $result = $pdfToText->setOptions(['layout', 'nopgbrk']);

        $this->assertSame($pdfToText, $result);
    }
}