<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Data\Profile\ProfileData;
use App\Integrations\RandomUser\Client as RandomUserClient;
use App\Models\Profile\Profile;
use Cache;
use DB;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

final class SaveProfile
{
    use AsAction;

    public $commandSignature = "profile:hourly-sync {result}";

    /**
     * @throws Throwable
     */
    public function handle(ProfileData $data): void
    {
        $profile = Profile::whereUuid($data->uuid)->firstOrNew();

        $profile->uuid = $data->uuid;
        $profile->name = $data->name;
        $profile->full_name = $data->full_name;
        $profile->gender = $data->gender;
        $profile->location = $data->location;
        $profile->age = $data->age;

        DB::transaction(fn () => $profile->save());

        $variableName = "male_count";

        if ( ! $profile->gender) {
            $variableName = "female_count";
        }

        if (null === cache($variableName)) {
            Cache::forever($variableName, 1);
        } else {
            Cache::increment($variableName);
        }
    }

    /**
     * @throws Throwable
     */
    public function asJob(ProfileData $data): void
    {
        $this->handle($data);
    }

    public function asCommand(Command $command): void
    {
        $client = new RandomUserClient();

        $client
            ->getUsers((int)$command->argument('result'))
            ->each(function ($user): void {
                SaveProfile::dispatch(ProfileData::fromResponse($user));
            });
    }
}
