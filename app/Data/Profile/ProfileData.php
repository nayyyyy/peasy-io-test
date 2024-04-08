<?php

declare(strict_types=1);

namespace App\Data\Profile;

use Spatie\LaravelData\Data;

final class ProfileData extends Data
{
    public function __construct(
        public ?int   $id,
        public string $uuid,
        public bool   $gender,
        public array  $name,
        public string $full_name,
        public array  $location,
        public int    $age,
    ) {
    }

    public static function fromResponse(array $response): self
    {
        $gender = ! ('female' === $response['gender']);

        return new self(
            id: null,
            uuid: $response['login']['uuid'],
            gender: $gender,
            name: $response['name'],
            full_name: implode(' ', $response['name']),
            location: $response['location'],
            age: $response['dob']['age']
        );
    }
}
