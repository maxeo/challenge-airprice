<?php

namespace App\Models\Website;

use App\Models\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Permission;

/**
 * App\Models\Website\WebsiteNavigation
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string|null $icon
 * @property int $position
 * @property int $group_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|WebsiteNavigation newModelQuery()
 * @method static Builder|WebsiteNavigation newQuery()
 * @method static Builder|WebsiteNavigation query()
 * @method static Builder|WebsiteNavigation whereCreatedAt($value)
 * @method static Builder|WebsiteNavigation whereDeletedAt($value)
 * @method static Builder|WebsiteNavigation whereGroupId($value)
 * @method static Builder|WebsiteNavigation whereIcon($value)
 * @method static Builder|WebsiteNavigation whereId($value)
 * @method static Builder|WebsiteNavigation whereLink($value)
 * @method static Builder|WebsiteNavigation wherePosition($value)
 * @method static Builder|WebsiteNavigation whereTitle($value)
 * @method static Builder|WebsiteNavigation whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $permission_id
 * @property-read \App\Models\Website\WebsiteNavigationGroup $group
 * @property-read Permission $permission
 * @method static Builder|WebsiteNavigation wherePermissionId($value)
 * @property int|null $parent_id
 * @method static Builder|WebsiteNavigation whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|WebsiteNavigation onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|WebsiteNavigation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|WebsiteNavigation withoutTrashed()
 */
class WebsiteNavigation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Returns Available Navigation where $user has permission
     *
     * @param User $user
     * @return array
     */
    public function getAvailableFromUser(User $user): array
    {
        $g = (new WebsiteNavigationGroup())->getTable();
        $p = (new Permission())->getTable();
        $n = $this->getTable();

        $navigation = $this->from($n)
            ->select([
                "$n.id",
                "$n.title",
                "$n.link",
                "$n.icon",
                "$n.parent_id",
                "$g.name AS group_name",
                "$p.name AS permission_name"
            ])
            ->leftJoin($p, "$p.id", '=', "$n.permission_id")
            ->leftJoin($g, "$g.id", '=', "$n.group_id")
            ->orderBy("$g.position")
            ->orderBy("$n.position")
            ->get();

        $routes = [];
        foreach ($navigation as $route) {

            if ($user->hasPermissionTo($route->permission_name)) {
                $routes[] = [
                    'id' => $route->id,
                    'title' => $route->title,
                    'link' => $route->link,
                    'icon' => $route->icon,
                    'parent_id' => $route->parent_id,
                    'group_name' => $route->group_name,
                ];
            }


        }

        return $routes;
    }

    /**
     * @return BelongsTo
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(WebsiteNavigationGroup::class);
    }

}
