<?php

declare(strict_types=1);

use App\Integrations\RandomUser\Client as RandomUserClient;

it('can get random user', function (): void {
    $client = new RandomUserClient();

    $totalUserRequest = 20;
    $response = $client->getUsers($totalUserRequest);

    expect($response->count())->toBe($totalUserRequest);
});
