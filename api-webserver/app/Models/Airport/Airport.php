<?php

namespace App\Models\Airport;

use App\Http\Traits\WebsiteTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Airport\Airport
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $lat
 * @property string $lng
 * @method static Builder|Airport newModelQuery()
 * @method static Builder|Airport newQuery()
 * @method static Builder|Airport query()
 * @method static Builder|Airport whereCode($value)
 * @method static Builder|Airport whereId($value)
 * @method static Builder|Airport whereLat($value)
 * @method static Builder|Airport whereLng($value)
 * @method static Builder|Airport whereName($value)
 * @mixin Eloquent
 */
class Airport extends Model
{
    use HasFactory, WebsiteTrait;

    /**
     * @var array|array[]
     */
    public static array $form = [
        [
            'name' => 'id',
            'label' => 'ID',
            'primary' => true,
        ],
        [
            'name' => 'name',
            'render' => [
                'type' => 'text',
                'label' => 'Nome',
                'required' => true,
            ],
        ],
        [
            'name' => 'code',
            'render' => [
                'type' => 'text',
                'label' => 'Codice',
                'required' => true,
            ],
        ],
        [
            'name' => 'lat',
            'render' => [
                'type' => 'text',
                'label' => 'Latitudine',
                'required' => true,
            ],
        ],
        [
            'name' => 'lng',
            'render' => [
                'type' => 'text',
                'label' => 'Longitudine',
                'required' => true,
            ],
        ],

    ];
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'lat',
        'lng',
    ];

}
