<?php

namespace Escarter\PopplerPhp;

use Escarter\PopplerPhp\Exceptions\CouldNotSplitPdf;
use Escarter\PopplerPhp\Exceptions\PdfNotFound;
use Symfony\Component\Process\Process;

class PdfSeparate
{
    protected $pdf;

    protected $destination;

    protected $binPath;

    protected $options = [];

    public function __construct(string $binPath = null)
    {
        $this->binPath = $binPath ?? '/usr/bin/pdfseparate';
    }

    public function setPdf(string $pdf): self
    {
        if (! is_readable($pdf)) {
            throw new PdfNotFound("Could not read `{$pdf}`");
        }

        $this->pdf = $pdf;

        return $this;
    }

    public function setDestination(string $destination): self
    {
        // if (!is_readable($pdf)) {
        //     throw new PdfNotFound("Could not read `{$pdf}`");
        // }

        $this->destination = $destination;

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $this->parseOptions($options);

        return $this;
    }

    public function addOptions(array $options): self
    {
        $this->options = array_merge(
            $this->options,
            $this->parseOptions($options)
        );

        return $this;
    }

    protected function parseOptions(array $options): array
    {
        $mapper = function (string $content): array {
            $content = trim($content);
            if ('-' !== ($content[0] ?? '')) {
                $content = '-' . $content;
            }

            return explode(' ', $content, 2);
        };

        $reducer = function (array $carry, array $option): array {
            return array_merge($carry, $option);
        };

        return array_reduce(array_map($mapper, $options), $reducer, []);
    }

    public function split(): string
    {
        $process = new Process(array_merge([$this->binPath], $this->options, [$this->pdf], [$this->destination]));
        $process->run();
        if (! $process->isSuccessful()) {
            throw new CouldNotSplitPdf($process);
        }

        return trim($process->getOutput(), " \t\n\r\0\x0B\x0C");
    }

    public static function getOutput(string $pdf, string $binPath = null, string $destination = null, array $options = []): string
    {
        return (new static($binPath))
            ->setOptions($options)
            ->setPdf($pdf)
            ->setDestination($destination)
            ->split();
    }
}
