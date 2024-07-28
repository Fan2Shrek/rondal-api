<?php

namespace App\Services\Interfaces;

interface RequestPreparerInterface
{
    public function prepareRequest(string $url): array;
}
