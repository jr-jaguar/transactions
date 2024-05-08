<?php

namespace App\Infrastructure\FileParser;

use App\Infrastructure\FileParser\FileParserInterface;

class FileParser implements FileParserInterface
{
    public function parseTransactions(string $filePath): \Generator
    {
        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception("Unable to open file: $filePath");
        }

        while (!feof($handle)) {
            $line = fgets($handle);
            if (!empty($line)) {
                yield json_decode($line, true);
            }
        }

        fclose($handle);
    }
}
