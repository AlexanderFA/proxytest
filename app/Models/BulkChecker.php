<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\AsyncClientInterface;
use GuzzleHttp\Promise\Utils;

class BulkChecker
{
    private const DEFAULT_QUERY_CONFIG = ['asn' => 1, 'cur' => 0, 'time' => 1, 'short' => 1];

    private bool $isProcessed = false;
    private array $result = [];
    private int $total = 0;
    private int $worked = 0;

    public function __construct(private array $sockets, private AsyncClientInterface $client)
    {
    }

    public function process(): void
    {
        $promises = [];
        foreach ($this->sockets as $socket) {
            $promises[$socket] = $this->client->checkAsync($socket);
        }
        $responses = Utils::settle(Utils::unwrap($promises))->wait();

        $this->prepareResult($responses);
        $this->isProcessed = true;
    }

    public function isProcessed(): bool
    {
        return $this->isProcessed;
    }

    public function getResult(): array
    {
        return $this->result;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getWorked(): int
    {
        return $this->worked;
    }

    private function prepareResult(array $responses): void
    {
        $this->total = count($this->sockets);
        foreach ($responses as $socket => $response) {
            $data = json_decode($response['value']->getBody()->getContents());
            if ('denied' === ($data->status ?? false)) {
                throw new \Exception('Access denied by third parties');
            }
            if ('yes' === ($data->proxy ?? false)) {
                $this->result[$socket] = $data;
                ('ok' === ($data->status ?? false)) && $this->worked++;
            }
        }
    }
}
