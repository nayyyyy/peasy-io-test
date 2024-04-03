<?php

declare(strict_types=1);

namespace App\Models\Profile;

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
 * @method static Builder|Profile whereAge($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereDeletedAt($value)
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
        'age' => 'integer'
    ];

    public function scopeCreatedToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeIsFemale(Builder $query): Builder
    {
        return $query->where('gender', false);
    }

    public function scopeIsMale(Builder $query): Builder
    {
        return $query->where('gender', true);
    }
}
