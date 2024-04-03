<?php

declare(strict_types=1);

use App\Actions\Profile\SaveProfile;
use App\Data\Profile\ProfileData;
use App\Integrations\RandomUser\Client as RandomUserClient;

use function Pest\Laravel\assertDatabaseHas;

it('can save random user API response to database and gender total to cache', function (): void {
    $client = new RandomUserClient();

    $response = $client
        ->getUsers()
        ->each(function ($user): void {
            SaveProfile::run(ProfileData::fromResponse($user));
        });

    $response->each(function ($user): void {
        assertDatabaseHas('profiles', ProfileData::fromResponse($user)->only('uuid')->toArray());
    });

    $maleData = $response->filter(fn ($item) => ! ('female' === $item['gender']));
    $femaleData = $response->filter(fn ($item) => ! ('male' === $item['gender']));

    $maleCount = $maleData->count();
    $femaleCount = $femaleData->count();

    expect((int)Cache::get('male_count'))->toBe($maleCount)
        ->and((int)Cache::get('female_count'))->toBe($femaleCount);
});
