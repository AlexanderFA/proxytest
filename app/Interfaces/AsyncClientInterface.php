<?php

declare(strict_types=1);

namespace App\Interfaces;

interface AsyncClientInterface
{
    public function checkAsync(string $socket);
}
