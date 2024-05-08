<?php

namespace App\Infrastructure\CurrencyRatesProvider;

use App\Infrastructure\CurrencyRatesProvider\CurrencyRatesProviderInterface;

class ExchangeRatesApi implements CurrencyRatesProviderInterface
{
    private $apiKey = 'CgpPBdUCXFfa8yQpQr2vFoF69bSJ1uGx';
    private $apiUrl;
    private $ratesCache = [];

    public function __construct()
    {
        $this->apiUrl = 'https://api.apilayer.com/exchangerates_data/latest';
    }

    public function getExchangeRate(string $currency): float
    {
        if (!isset($this->ratesCache[$currency])) {
            $this->fetchRates();
        }

        if (isset($this->ratesCache[$currency])) {
            return $this->ratesCache[$currency];
        }

        throw new \Exception('Unable to retrieve exchange rate for currency ' . $currency);
    }

    private function fetchRates(): void
    {
        $url = $this->apiUrl . '?base=EUR&apikey=' . $this->apiKey;
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data['success']) && $data['success'] && isset($data['rates'])) {
            $this->ratesCache = $data['rates'];
        } else {
            throw new \Exception('Unable to fetch exchange rates from API.');
        }
    }
}
