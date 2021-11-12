<?php

namespace App\Models\Airport;

use DB;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\AirStat
 *
 * @property int $id
 * @property string $key_name
 * @property int $key_value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|AirStat newModelQuery()
 * @method static Builder|AirStat newQuery()
 * @method static Builder|AirStat query()
 * @method static Builder|AirStat whereCreatedAt($value)
 * @method static Builder|AirStat whereId($value)
 * @method static Builder|AirStat whereKeyName($value)
 * @method static Builder|AirStat whereKeyValue($value)
 * @method static Builder|AirStat whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AirStat extends Model
{
    use HasFactory;


    /**
     * @param string $key
     * @return bool|int
     */
    public static function incrementCounter(string $key): bool|int
    {
        return AirStat::where('key_name', '=', $key)->update(['key_value' => DB::raw('key_value*1+1')]);
    }

}
