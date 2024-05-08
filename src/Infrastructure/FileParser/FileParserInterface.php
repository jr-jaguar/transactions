<?php

namespace App\Infrastructure\FileParser;

interface FileParserInterface
{
    public function parseTransactions(string $filePath): \Generator;
}
