<?php

namespace App\Models;


use App\Http\Traits\WebsiteTrait;
use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @property string $username
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|User permission($permissions)
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereUsername($value)
 * @property string $first_name
 * @property string $last_name
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereLastName($value)
 * @property string|null $deleted_at
 * @method static Builder|User whereDeletedAt($value)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, WebsiteTrait;

    /**
     * @var array[]
     */
    public static array $form = [
        [
            'name' => 'id',
            'label' => 'ID',
            'primary' => true,
        ],
        [
            'name' => 'first_name',
            'render' => [
                'type' => 'text',
                'label' => 'Nome',
                'required' => true,
            ],
        ],
        [
            'name' => 'last_name',
            'render' => [
                'type' => 'text',
                'label' => 'Cognome',
                'required' => true,
            ],
        ],
        [
            'name' => 'username',
            'render' => [
                'type' => 'text',
                'label' => 'Username',
                'required' => true,
            ],
        ],
        [
            'name' => 'email',
            'render' => [
                'type' => 'email',
                'label' => 'Email',
            ],
            'validate' => ['required', 'max:255']
        ],
        [
            'name' => 'password',
            'render' => [
                'type' => 'password',
                'label' => 'Password',
            ],
            'hidden' => true,
            'validate' => ['required']
        ],
        [
            'name' => 'roles',
            'hidden' => false,
            'relation' => true,
            'with' => ['id', 'name'],
            'relation_info' => [
                'select_model' => Role::class,
                'method_select' => null,
                'model_update' => false,
                'method_update' => null,
            ],
            'render' => [
                'type' => 'select',
                'multiple' => true,
                'label' => 'Ruoli',
                'key' => 'id',
                'option' => 'name',
            ],
        ],
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'roles',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


}
