<?php

namespace App\Models\Permission;

use App\Http\Traits\WebsiteTrait;
use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission  as PermissionBase;
use Spatie\Permission\Models\Role as RoleBase;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission query()
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereGuardName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read Collection|PermissionBase[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|RoleBase[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|Permission permission($permissions)
 * @method static Builder|Permission role($roles, $guard = null)
 */
class Permission extends PermissionBase
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
    ];

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
