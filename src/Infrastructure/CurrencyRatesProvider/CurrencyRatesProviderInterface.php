<?php

namespace App\Infrastructure\CurrencyRatesProvider;

interface CurrencyRatesProviderInterface
{
    public function getExchangeRate(string $currency): float;
}
