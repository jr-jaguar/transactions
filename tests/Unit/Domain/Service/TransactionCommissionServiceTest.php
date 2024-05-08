<?php

namespace Tests\Domain\Service;

use App\Domain\Commission\CommissionStrategyManager;
use App\Domain\Model\TransactionBuilder;
use App\Domain\Service\TransactionCommissionService;
use App\Infrastructure\CurrencyRatesProvider\CurrencyRatesProviderInterface;
use PHPUnit\Framework\TestCase;

class TransactionCommissionServiceTest extends TestCase
{
    public function testCalculateCommission()
    {
        $strategyManagerMock = $this->createMock(CommissionStrategyManager::class);
        $currencyRatesProviderMock = $this->createMock(CurrencyRatesProviderInterface::class);

        $strategyManagerMock->method('getCommissionCoefficient')->willReturn(0.01);
        $currencyRatesProviderMock->method('getExchangeRate')->willReturn(0.93);

        $service = new TransactionCommissionService($strategyManagerMock, $currencyRatesProviderMock);

        $transaction = (new TransactionBuilder())
            ->setBin('123456')
            ->setAmount(100)
            ->setCurrency('USD')
            ->build();

        $commission = $service->calculateCommission($transaction);
        $this->assertEquals(0.93, $commission);
    }
}
