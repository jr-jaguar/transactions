<?php

namespace App\Domain\Model;

use App\Domain\Model\Interfaces\TransactionInterface;

class TransactionBuilder
{
    private $bin;
    private $amount;
    private $currency;

    public function setBin(string $bin): self
    {
        $this->bin = $bin;
        return $this;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function build(): TransactionInterface
    {
        if (empty($this->bin) || empty($this->amount) || empty($this->currency)) {
            throw new \Exception("Cannot build Transaction: missing required parameters");
        }

        $transaction = new Transaction();
        $transaction->setBin($this->bin);
        $transaction->setAmount($this->amount);
        $transaction->setCurrency($this->currency);

        return $transaction;
    }
}
