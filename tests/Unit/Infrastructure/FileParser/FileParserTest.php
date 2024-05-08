<?php

namespace Tests\Infrastructure\FileParser;

use App\Infrastructure\FileParser\FileParser;
use PHPUnit\Framework\TestCase;

class FileParserTest extends TestCase
{
    public function testParseTransactionsWithValidFile()
    {
        $filePath = 'test_input.txt';
        file_put_contents($filePath, '{"bin": "123456", "amount": 100.5, "currency": "USD"}');

        $parser = new FileParser();
        $transactions = $parser->parseTransactions($filePath);

        $this->assertIsIterable($transactions);
        $this->assertNotEmpty(iterator_to_array($transactions));

        unlink($filePath);
    }
}
