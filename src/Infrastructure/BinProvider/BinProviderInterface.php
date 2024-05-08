<?php

namespace App\Infrastructure\BinProvider;

interface BinProviderInterface
{
    public function getCountryCode(string $bin): string;
}
