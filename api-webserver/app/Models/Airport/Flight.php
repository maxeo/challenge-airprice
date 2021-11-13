<?php

namespace App\Models\Airport;

use App\Http\Traits\WebsiteTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\Airport\Flight
 *
 * @property string $code_departure
 * @property string $code_arrival
 * @property string $price
 * @method static Builder|Flight newModelQuery()
 * @method static Builder|Flight newQuery()
 * @method static Builder|Flight query()
 * @method static Builder|Flight whereCodeArrival($value)
 * @method static Builder|Flight whereCodeDeparture($value)
 * @method static Builder|Flight wherePrice($value)
 * @mixin Eloquent
 */
class Flight extends Model
{
    use HasFactory, WebsiteTrait;

    public static array $form = [
        [
            'name' => 'id',
            'label' => 'ID',
            'primary' => true,
        ],
        [
            'name' => 'departure',
            'hidden' => false,
            'relation' => true,
            'with' => ['code', 'name'],
            'relation_info' => [
                'select_model' => Airport::class,
                'method_select' => null,
                'model_update' => Flight::class,
                'method_update_key' => 'code_departure',
                'method_update' => null,
            ],
            'render' => [
                'type' => 'select',
                'multiple' => false,
                'label' => 'Aeroporto di Partenza',
                'key' => 'code',
                'option' => 'name',
            ],
        ],
        [
            'name' => 'arrival',
            'hidden' => false,
            'relation' => true,
            'with' => ['code', 'name'],
            'relation_info' => [
                'select_model' => Airport::class,
                'method_select' => null,
                'model_update' => Flight::class,
                'method_update_key' => 'code_arrival',
                'method_update' => null,
            ],
            'render' => [
                'type' => 'select',
                'multiple' => false,
                'label' => 'Aeroporto di Arrivo',
                'key' => 'code',
                'option' => 'name',
            ],
        ],
        [
            'name' => 'price',
            'render' => [
                'type' => 'text',
                'label' => 'Costo del Biglietto',
                'required' => true,
            ],
        ],
    ];
    public $timestamps = false;
    protected $fillable = [
        'code_departure',
        'code_arrival',
        'price',
    ];

    /**
     * @param string $code_departure
     * @param string $code_arrival
     * @return Collection
     */
    static function getBetterFlightsList(string $code_departure, string $code_arrival): Collection
    {
        $f = (new self())->getTable();

        $query = DB::table("$f AS f")
            ->select(DB::raw('f.code_departure AS departure_0,
                                   f.code_arrival AS arrival_0,
                                   f1.code_departure AS departure_1,
                                   f1.code_arrival AS arrival_1,
                                   NULL AS departure_2,
                                   NULL AS arrival_2,
                                   f1.code_arrival IS NULL AS direct,
                                   IF(f1.code_arrival IS NULL, 0, 1) AS stop_over,
                                   IF(f1.code_arrival IS NULL, f.price, f.price + f1.price) AS price'
            ))
            ->leftJoin("$f AS f1", function ($join) use ($code_arrival) {
                $join->on('f1.code_departure', '=', 'f.code_arrival')
                    ->where('f1.code_arrival', '=', $code_arrival);
            })
            ->where('f.code_departure', '=', $code_departure)
            ->where(function ($query) use ($code_arrival) {
                $query->where('f.code_arrival', '=', $code_arrival)
                    ->orWhere('f1.code_arrival', '=', $code_arrival);
            })->union(
                DB::table("$f AS f")
                    ->select(DB::raw('f.code_departure AS departure_0,
                                    f.code_arrival AS arrival_0,
                                    f1.code_departure AS departure_1,
                                    f1.code_arrival AS arrival_1,
                                    f2.code_departure AS departure_2,
                                    f2.code_arrival AS arrival_2,
                                    false AS direct,
                                    2 AS stop_over,
                                    f.price + f1.price + f2.price AS price '
                    ))
                    ->leftJoin("$f AS f1", 'f1.code_departure', '=', 'f.code_arrival')
                    ->leftJoin("$f AS f2", 'f2.code_departure', '=', 'f1.code_arrival')
                    ->where('f.code_departure', '=', $code_departure)
                    ->where('f2.code_arrival', '=', $code_arrival)
                    ->where('f1.code_departure', '!=', $code_arrival)
                    ->where('f1.code_arrival', '=', $code_departure)
            )->orderBy('price');

        return $query->get();

    }

    protected function departure()
    {
        return $this->belongsTo(Airport::class, 'code_departure', 'code');
    }

    protected function arrival()
    {
        return $this->belongsTo(Airport::class, 'code_arrival', 'code');
    }

}
