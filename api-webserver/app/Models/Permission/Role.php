<?php

namespace App\Models\Permission;

use App\Http\Traits\WebsiteTrait;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as RoleBase;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role permission($permissions)
 * @mixin Eloquent
 */
class Role extends RoleBase
{
    use HasFactory, WebsiteTrait;

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
            'name' => 'permissions',
            'hidden' => false,
            'relation' => true,
            'with' => ['id', 'name'],
            'relation_info' => [
                'select_model' => Permission::class,
                'method_select' => null,
                'model_update' => false,
                'method_update' => null,
            ],
            'render' => [
                'type' => 'select',
                'multiple' => true,
                'label' => 'Permessi',
                'key' => 'id',
                'option' => 'name',
            ],
        ],
    ];

    protected $fillable = [
        'name',
        'permissions',
        'guard_name',
    ];
}
