<?php

namespace Tests\Domain\Commission;

use App\Domain\Commission\CommissionStrategyManager;
use App\Domain\Commission\Strategies\CommissionStrategyInterface;
use App\Domain\Model\Interfaces\TransactionInterface;
use App\Domain\Model\TransactionBuilder;
use App\Infrastructure\BinProvider\BinProviderInterface;
use PHPUnit\Framework\TestCase;

class CommissionStrategyManagerTest extends TestCase
{
    public function testGetCommissionCoefficient()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getCountryCode')->willReturn('FR');

        $transactionBuilder = new TransactionBuilder();

        $euTransaction = $transactionBuilder
            ->setBin('123456')
            ->setAmount(100.0)
            ->setCurrency('EUR')
            ->build();

        $nonEuTransaction = $transactionBuilder
            ->setBin('123456')
            ->setAmount(100.0)
            ->setCurrency('USD')
            ->build();

        $strategyManager = new CommissionStrategyManager($binProviderMock);
        $reflection = new \ReflectionProperty(CommissionStrategyManager::class, 'strategies');

        $reflection->setAccessible(true);

        $reflection->setValue($strategyManager, [
            new class implements CommissionStrategyInterface {
                public function isApplicable(TransactionInterface $transaction): bool
                {
                    return $transaction->getCurrency() === 'EUR';
                }

                public function getCommissionRate(): float
                {
                    return 0.01;
                }
            },
            new class implements CommissionStrategyInterface {
                public function isApplicable(TransactionInterface $transaction): bool
                {
                    return $transaction->getCurrency() !== 'EUR';
                }

                public function getCommissionRate(): float
                {
                    return 0.02;
                }
            }
        ]);

        $this->assertEquals(0.01, $strategyManager->getCommissionCoefficient($euTransaction));

        $this->assertEquals(0.02, $strategyManager->getCommissionCoefficient($nonEuTransaction));
    }
}
