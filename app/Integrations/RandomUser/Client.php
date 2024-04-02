<?php

declare(strict_types=1);

namespace App\Integrations\RandomUser;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class Client
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(config('integration.random_user.base_url'));
    }

    public function getUsers(int $result = 20): PromiseInterface|Collection
    {
        $response = $this->client->get('api', [
            'results' => $result
        ]);

        return $this->parseResponse($response);
    }

    private function parseResponse(Response|PromiseInterface $response): Collection
    {
        return collect($response->json("results"));
    }
}
