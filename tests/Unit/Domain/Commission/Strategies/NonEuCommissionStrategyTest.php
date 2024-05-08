<?php

namespace Tests\Domain\Commission\Strategies;

use App\Domain\Commission\Strategies\NonEuCommissionStrategy;
use App\Domain\Model\TransactionBuilder;
use App\Infrastructure\BinProvider\BinProviderInterface;
use PHPUnit\Framework\TestCase;

class NonEuCommissionStrategyTest extends TestCase
{
    public function testIsApplicableForNonEuTransaction()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getCountryCode')->willReturn('US'); // Код страны не из Европейского союза

        $transactionBuilder = new TransactionBuilder();
        $transaction = $transactionBuilder
            ->setBin('123456')
            ->setAmount(100.0)
            ->setCurrency('USD')
            ->build();

        $strategy = new NonEuCommissionStrategy($binProviderMock);

        $this->assertTrue($strategy->isApplicable($transaction));
    }

    public function testIsApplicableForEuTransaction()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);
        $binProviderMock->method('getCountryCode')->willReturn('FR'); // Код страны из Европейского союза

        $transactionBuilder = new TransactionBuilder();
        $transaction = $transactionBuilder
            ->setBin('123456')
            ->setAmount(100.0)
            ->setCurrency('EUR')
            ->build();

        $strategy = new NonEuCommissionStrategy($binProviderMock);

        $this->assertFalse($strategy->isApplicable($transaction));
    }

    public function testGetCommissionRate()
    {
        $binProviderMock = $this->createMock(BinProviderInterface::class);

        $strategy = new NonEuCommissionStrategy($binProviderMock);

        $expectedCommissionRate = 0.02; // Комиссия для стран не из Европейского союза
        $actualCommissionRate = $strategy->getCommissionRate();

        $this->assertEquals($expectedCommissionRate, $actualCommissionRate);
    }
}
