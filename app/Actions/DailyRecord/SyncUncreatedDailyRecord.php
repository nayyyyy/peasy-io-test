<?php

declare(strict_types=1);

namespace App\Actions\DailyRecord;

use App\Models\Profile\Profile;
use App\Models\Record\DailyRecord;
use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;

final class SyncUncreatedDailyRecord
{
    use AsAction;

    public $commandSignature = "record:uncreated-sync";

    public function handle(): void
    {
        $uncreatedDailyRecordDates = Profile::select('created_at')
            ->get()
            ->map(fn (Profile $profile) => $profile->created_at->format('d-m-Y'))
            ->unique();

        $uncreatedDailyRecordDates->each(function ($date): void {
            $dailyRecord = DailyRecord::whereDate('created_at', $date)->first();

            if ( ! $dailyRecord) {
                $dailyRecord = new DailyRecord();

                $profiles = Profile::whereDate('created_at', Carbon::createFromFormat('d-m-Y', $date))->get();

                $dailyRecord->male_count = $profiles->filter(fn ($profile) => $profile->gender)->count();
                $dailyRecord->male_avg_age = $profiles->filter(fn ($profile) => $profile->gender)->average('age');
                $dailyRecord->female_count = $profiles->filter(fn ($profile) => ! $profile->gender)->count();
                $dailyRecord->female_avg_age = $profiles->filter(fn ($profile) => ! $profile->gender)->average('age');

                $dailyRecord->save();
            }
        });
    }

    public function asCommand(): void
    {
        $this->handle();
    }
}
