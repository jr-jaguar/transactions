<?php

namespace App\Domain\Model\Interfaces;

interface TransactionInterface
{
    public function getBin(): string;

    public function setBin(string $bin): self;

    public function getAmount(): float;

    public function setAmount(float $amount): self;

    public function getCurrency(): string;

    public function setCurrency(string $currency): self;
}
