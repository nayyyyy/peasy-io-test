<?php

declare(strict_types=1);

namespace App\Models\Profile;

use App\Models\Record\DailyRecord;
use Cache;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int $id
 * @property string $uuid
 * @property bool $gender 0 is Female and 1 is Male
 * @property array $name
 * @property string $full_name
 * @property array $location
 * @property int $age
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|Profile createdToday()
 * @method static Builder|Profile isFemale()
 * @method static Builder|Profile isMale()
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile onlyTrashed()
 * @method static Builder|Profile query()
 * @method static Builder|Profile updatedToday()
 * @method static Builder|Profile whereAge($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereDeletedAt($value)
 * @method static Builder|Profile whereFullName($value)
 * @method static Builder|Profile whereGender($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereLocation($value)
 * @method static Builder|Profile whereName($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 * @method static Builder|Profile whereUuid($value)
 * @method static Builder|Profile withTrashed()
 * @method static Builder|Profile withoutTrashed()
 * @mixin Eloquent
 */
final class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "profiles";

    protected $guarded = [
        'uuid',
        'gender',
        'name',
        'location',
        'age'
    ];

    protected $casts = [
        'gender' => 'bool',
        'name' => 'array',
        'location' => 'array',
        'age' => 'integer',
        'created_at' => 'datetime:d-m-Y H:i:s'
    ];

    public function scopeCreatedToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeUpdatedToday(Builder $query): Builder
    {
        return $query->whereDate('updated_at', today());
    }

    public function scopeIsFemale(Builder $query): Builder
    {
        return $query->where('gender', false);
    }

    public function scopeIsMale(Builder $query): Builder
    {
        return $query->where('gender', true);
    }

    protected static function booted(): void
    {
        parent::booted();

        self::deleted(static function (self $profile): void {
            /** @var DailyRecord $dailyRecord */
            $dailyRecord = DailyRecord::whereDate('created_at', $profile->created_at)->first();

            $variableName = 'male_count';

            if ( ! $profile->gender) {
                $variableName = 'female_count';
            }

            if ($dailyRecord) {
                if ($profile->gender) {
                    $dailyRecord->decrement($variableName);
                    $dailyRecord->male_avg_age = Profile::whereDate('created_at', $profile->created_at)
                        ->isMale()
                        ->average('age');
                } else {
                    $dailyRecord->decrement($variableName);
                    $dailyRecord->female_avg_age = Profile::whereDate('created_at', $profile->created_at)
                        ->isFemale()
                        ->average('age');
                }

                $dailyRecord->save();
            }

            Cache::decrement($variableName);
        });
    }
}
