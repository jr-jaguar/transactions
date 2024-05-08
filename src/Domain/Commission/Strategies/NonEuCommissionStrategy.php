<?php

namespace App\Domain\Commission\Strategies;

use App\Domain\Model\Interfaces\TransactionInterface;
use App\Infrastructure\BinProvider\BinProviderInterface;

class NonEuCommissionStrategy implements CommissionStrategyInterface
{
    public function __construct(private BinProviderInterface $binProvider)
    {
    }

    public function isApplicable(TransactionInterface $transaction): bool
    {
        $countryCode = $this->binProvider->getCountryCode($transaction->getBin());
        return !$this->isEuCountry($countryCode);
    }

    public function getCommissionRate(): float
    {
        return 0.02;
    }

    private function isEuCountry(string $countryCode): bool
    {
        $euCountries = [
            'AT',
            'BE',
            'BG',
            'CY',
            'CZ',
            'DE',
            'DK',
            'EE',
            'ES',
            'FI',
            'FR',
            'GR',
            'HR',
            'HU',
            'IE',
            'IT',
            'LT',
            'LU',
            'LV',
            'MT',
            'NL',
            'PO',
            'PT',
            'RO',
            'SE',
            'SI',
            'SK'
        ];

        return in_array($countryCode, $euCountries);
    }
}
