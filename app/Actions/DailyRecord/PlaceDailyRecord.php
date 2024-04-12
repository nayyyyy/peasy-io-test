<?php

declare(strict_types=1);

namespace App\Actions\DailyRecord;

use App\Models\Profile\Profile;
use App\Models\Record\DailyRecord;
use Illuminate\Support\Facades\Cache;
use Log;
use Lorisleiva\Actions\Concerns\AsAction;
use Throwable;

final class PlaceDailyRecord
{
    use AsAction;

    public $commandSignature = "record:daily-sync";

    public function handle(): void
    {
        $dailyRecord = new DailyRecord();

        $dailyRecord->male_count = Cache::get('male_count') ?? 0;
        $dailyRecord->female_count = Cache::get('female_count') ?? 0;
        $dailyRecord->male_avg_age = Profile::updatedToday()
            ->isMale()
            ->average('age') ?? 0;
        $dailyRecord->female_avg_age = Profile::updatedToday()
            ->isFemale()
            ->average('age') ?? 0;

        $dailyRecord->save();
    }

    public function asCommand(): void
    {
        Log::channel('daily-record')->info('Start save a daily record !');

        try {
            $this->handle();
            Log::channel('daily-record')->info('Success save a daily record !');
        } catch (Throwable $throwable) {
            Log::channel('daily-record')->error('Failed save a daily record !', [
                'message' => $throwable->getMessage()
            ]);
        }
    }
}
