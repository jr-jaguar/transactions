<?php

namespace Tests\Infrastructure\CurrencyRatesProvider;

use App\Infrastructure\CurrencyRatesProvider\ExchangeRatesApi;
use PHPUnit\Framework\TestCase;

class ExchangeRatesApiTest extends TestCase
{
    public function testGetExchangeRateWithValidCurrency()
    {
        $currency = 'USD';
        $provider = new ExchangeRatesApi();
        $exchangeRate = $provider->getExchangeRate($currency);
        $this->assertIsFloat($exchangeRate);
    }

    public function testGetExchangeRateWithInvalidCurrency()
    {
        $this->expectException(\Exception::class);
        $currency = 'XYZ';
        $provider = new ExchangeRatesApi();
        $provider->getExchangeRate($currency);
    }
}
