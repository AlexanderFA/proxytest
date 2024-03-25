<?php

declare(strict_types=1);

namespace App\Models;

use GuzzleHttp\Client;
use App\Interfaces\AsyncClientInterface;

class AsyncClient extends Client implements AsyncClientInterface
{
    private const DEFAULT_QUERY_CONFIG = ['asn' => 1, 'cur' => 0, 'time' => 1, 'short' => 1];

    public function checkAsync($socket)
    {
        $tmp = explode(':', $socket);
        [$ip, $port] = [$tmp[0], $tmp[1] ?? false];

        return $this->getAsync($ip, ['query' => self::DEFAULT_QUERY_CONFIG + ['port' => $port]]);
    }
}
