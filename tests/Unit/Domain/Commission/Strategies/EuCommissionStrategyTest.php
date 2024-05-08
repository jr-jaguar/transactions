<?php

namespace Tests\Domain\Commission\Strategies;

use App\Domain\Commission\Strategies\EuCommissionStrategy;
use App\Domain\Model\TransactionBuilder;
use App\Infrastructure\BinProvider\BinProviderInterface;
use PHPUnit\Framework\TestCase;

class EuCommissionStrategyTest extends TestCase
{
    public function testIsApplicableForEuTransaction()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getCountryCode')->willReturn('FR');

        $transactionBuilder = new TransactionBuilder();
        $transaction = $transactionBuilder
            ->setBin('123456')
            ->setAmount(100.0)
            ->setCurrency('EUR')
            ->build();

        $strategy = new EuCommissionStrategy($binProviderMock);

        $this->assertTrue($strategy->isApplicable($transaction));
    }

    public function testIsApplicableForNonEuTransaction()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getCountryCode')->willReturn('US');

        $transactionBuilder = new TransactionBuilder();
        $transaction = $transactionBuilder
            ->setBin('123456')
            ->setAmount(100.0)
            ->setCurrency('USD')
            ->build();

        $strategy = new EuCommissionStrategy($binProviderMock);

        $this->assertFalse($strategy->isApplicable($transaction));
    }

    public function testGetCommissionRate()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);

        $strategy = new EuCommissionStrategy($binProviderMock);

        $expectedCommissionRate = 0.01;
        $actualCommissionRate = $strategy->getCommissionRate();

        $this->assertEquals($expectedCommissionRate, $actualCommissionRate);
    }
}
