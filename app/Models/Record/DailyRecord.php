<?php

declare(strict_types=1);

namespace App\Models\Record;

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
 * @property int $male_count
 * @property int $female_count
 * @property float $male_avg_age
 * @property float $female_avg_age
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|DailyRecord newModelQuery()
 * @method static Builder|DailyRecord newQuery()
 * @method static Builder|DailyRecord onlyTrashed()
 * @method static Builder|DailyRecord query()
 * @method static Builder|DailyRecord today()
 * @method static Builder|DailyRecord whereCreatedAt($value)
 * @method static Builder|DailyRecord whereDeletedAt($value)
 * @method static Builder|DailyRecord whereFemaleAvgAge($value)
 * @method static Builder|DailyRecord whereFemaleCount($value)
 * @method static Builder|DailyRecord whereId($value)
 * @method static Builder|DailyRecord whereMaleAvgAge($value)
 * @method static Builder|DailyRecord whereMaleCount($value)
 * @method static Builder|DailyRecord whereUpdatedAt($value)
 * @method static Builder|DailyRecord withTrashed()
 * @method static Builder|DailyRecord withoutTrashed()
 * @mixin Eloquent
 */
final class DailyRecord extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "daily_records";

    protected $guarded = [
        'male_count',
        'female_count',
        'male_avg_age',
        'female_avg_age'
    ];

    protected $casts = [
        'male_count' => 'integer',
        'female_count' => 'integer',
        'male_avg_age' => 'float',
        'female_avg_age' => 'float',
        'created_at' => 'datetime:d-m-Y'
    ];

    protected $attributes = [
        'male_count' => 0,
        'female_count' => 0,
        'male_avg_age' => 0.0,
        'female_avg_age' => 0.0
    ];

    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }
}
