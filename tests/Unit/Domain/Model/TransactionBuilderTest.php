<?php

namespace Tests\Domain\Model;

use App\Domain\Model\Transaction;
use App\Domain\Model\TransactionBuilder;
use PHPUnit\Framework\TestCase;

class TransactionBuilderTest extends TestCase
{
    public function testBuildTransaction()
    {
        $builder = new TransactionBuilder();

        $bin = '123456';
        $amount = 100.00;
        $currency = 'USD';

        $transaction = $builder
            ->setBin($bin)
            ->setAmount($amount)
            ->setCurrency($currency)
            ->build();

        $this->assertInstanceOf(Transaction::class, $transaction);

        $this->assertEquals($bin, $transaction->getBin());
        $this->assertEquals($amount, $transaction->getAmount());
        $this->assertEquals($currency, $transaction->getCurrency());
    }

    public function testBuildTransactionWithMissingParameters()
    {
        $builder = new TransactionBuilder();

        $this->expectException(\Exception::class);
        $builder->build();
    }
}
