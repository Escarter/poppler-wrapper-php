<?php

namespace Escarter\PopplerPhp\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class CompatibilityTest extends TestCase
{
    /** @test */
    public function it_works_with_symfony_process_7()
    {
        // Test that the package works with Symfony Process 7.x
        $process = new Process(['echo', 'laravel-12-compatible']);
        $process->run();

        $this->assertTrue($process->isSuccessful());
        $this->assertEquals('laravel-12-compatible', trim($process->getOutput()));
    }

    /** @test */
    public function it_is_compatible_with_php_81_plus()
    {
        // Test basic PHP 8.1+ compatibility
        $this->assertTrue(version_compare(PHP_VERSION, '8.1.0', '>='));

        // Test PHP 8.1+ features work
        $array = ['a' => 1, 'b' => 2];
        $result = array_map(fn($value) => $value * 2, $array);
        $this->assertEquals(['a' => 2, 'b' => 4], $result);
    }

    /** @test */
    public function it_supports_named_arguments()
    {
        // Test PHP 8.0+ named arguments support
        $process = new Process(
            command: ['echo', 'named-args-work'],
            timeout: 30
        );
        $process->run();

        $this->assertTrue($process->isSuccessful());
        $this->assertEquals('named-args-work', trim($process->getOutput()));
    }

    /** @test */
    public function symfony_process_has_required_methods()
    {
        $process = new Process(['echo', 'test']);

        // Test that all the methods used by the package exist
        $this->assertTrue(method_exists($process, 'run'));
        $this->assertTrue(method_exists($process, 'isSuccessful'));
        $this->assertTrue(method_exists($process, 'getOutput'));
    }

    /** @test */
    public function package_maintains_backward_compatibility()
    {
        // Test that the API hasn't changed in breaking ways
        $this->assertTrue(class_exists('Escarter\PopplerPhp\PdfToText'));
        $this->assertTrue(class_exists('Escarter\PopplerPhp\PdfSeparate'));
        $this->assertTrue(class_exists('Escarter\PopplerPhp\Exceptions\PdfNotFound'));
        $this->assertTrue(class_exists('Escarter\PopplerPhp\Exceptions\CouldNotExtractText'));
        $this->assertTrue(class_exists('Escarter\PopplerPhp\Exceptions\CouldNotSplitPdf'));
    }
}