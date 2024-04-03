<?php

declare(strict_types=1);

namespace App\Actions\Profile;

use App\Models\Profile\Profile;
use App\Models\Record\DailyRecord;
use Lorisleiva\Actions\Concerns\AsAction;

final class PlaceDailyRecord
{
    use AsAction;

    public $commandSignature = "record:daily-sync";

    public function handle(): void
    {
        $dailyRecord = new DailyRecord();

        $dailyRecord->male_count = cache('male_count');
        $dailyRecord->female_count = cache('female_count');
        $dailyRecord->male_avg_age = Profile::updatedToday()
            ->isMale()
            ->average('age');
        $dailyRecord->female_avg_age = Profile::updatedToday()
            ->isFemale()
            ->average('age');

        $dailyRecord->save();
    }

    public function asCommand(): void
    {
        $this->handle();
    }
}
