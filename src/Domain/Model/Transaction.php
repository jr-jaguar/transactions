<?php

namespace App\Domain\Model;

use App\Domain\Model\Interfaces\TransactionInterface;

class Transaction implements TransactionInterface
{
    private $bin;
    private $amount;
    private $currency;

    public function getBin(): string
    {
        return $this->bin;
    }

    public function setBin(string $bin): self
    {
        $this->bin = $bin;
        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }
}
