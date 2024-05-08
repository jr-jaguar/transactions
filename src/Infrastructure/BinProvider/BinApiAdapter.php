<?php

namespace App\Infrastructure\BinProvider;

use App\Infrastructure\BinProvider\BinProviderInterface;

class BinApiAdapter implements BinProviderInterface
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'https://lookup.binlist.net/';
    }

    public function getCountryCode(string $bin): string
    {
        $url = $this->apiUrl . '/' . $bin;
        $response = @file_get_contents($url);
        $data = json_decode($response, true);

        if (isset($data["country"]["alpha2"])) {
            return $data["country"]["alpha2"];
        }

        throw new \Exception('Unable to retrieve country code for BIN ' . $bin);
    }
}
