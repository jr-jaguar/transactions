<?php

namespace App\Domain\Commission;

use App\Domain\Model\Interfaces\TransactionInterface;
use App\Infrastructure\BinProvider\BinProviderInterface;

class CommissionStrategyManager
{
    private $strategies = [];

    public function __construct(private BinProviderInterface $binProvider)
    {
        $strategyClasses = include __DIR__ . '/../../../config/strategies.php';

        foreach ($strategyClasses as $className) {
            $namespace = 'App\\Domain\\Commission\\Strategies\\' . $className;
            $this->strategies[] = new $namespace($this->binProvider);
        }
    }

    public function getCommissionCoefficient(TransactionInterface $transaction): ?float
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->isApplicable($transaction)) {
                return $strategy->getCommissionRate();
            }
        }

        throw new \Exception('No commission strategy found for the transaction.');
    }
}
