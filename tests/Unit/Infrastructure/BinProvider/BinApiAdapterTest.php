<?php

namespace Tests\Infrastructure\BinProvider;

use App\Infrastructure\BinProvider\BinApiAdapter;
use PHPUnit\Framework\TestCase;

class BinApiAdapterTest extends TestCase
{
    public function testGetCountryCodeWithValidBin()
    {
        $bin = '4745030';
        $adapter = new BinApiAdapter();
        $countryCode = $adapter->getCountryCode($bin);
        $this->assertEquals('LT', $countryCode);
    }

    public function testGetCountryCodeWithInvalidBin()
    {
        $this->expectException(\Exception::class);
        $bin = 'invalid_bin';
        $adapter = new BinApiAdapter();
        $adapter->getCountryCode($bin);
    }
}
