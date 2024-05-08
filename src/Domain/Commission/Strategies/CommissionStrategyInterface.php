<?php

namespace App\Domain\Commission\Strategies;

use App\Domain\Model\Interfaces\TransactionInterface;

interface CommissionStrategyInterface
{
    public function isApplicable(TransactionInterface $transaction): bool;

    public function getCommissionRate(): float;

}
