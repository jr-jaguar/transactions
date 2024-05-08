<?php

namespace App\Domain\Service;

use App\Domain\Commission\CommissionStrategyManager;
use App\Domain\Model\Interfaces\TransactionInterface;
use App\Infrastructure\CurrencyRatesProvider\CurrencyRatesProviderInterface;

class TransactionCommissionService
{
    public function __construct(
        private CommissionStrategyManager $strategyManager,
        private CurrencyRatesProviderInterface $currencyRatesProvider
    ) {
    }

    public function calculateCommission(TransactionInterface $transaction): float
    {
        $commissionRate = $this->strategyManager->getCommissionCoefficient($transaction);
        $exchangeRate = $this->currencyRatesProvider->getExchangeRate($transaction->getCurrency());

        $commission = $transaction->getAmount() * $exchangeRate * $commissionRate;

        $commission = ceil($commission * 100) / 100;

        return $commission;
    }
}
