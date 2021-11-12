<?php

namespace App\Models\Website;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Website\WebsiteNavigationGroup
 *
 * @property int $id
 * @property string $name
 * @property int $position
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|WebsiteNavigationGroup newModelQuery()
 * @method static Builder|WebsiteNavigationGroup newQuery()
 * @method static Builder|WebsiteNavigationGroup query()
 * @method static Builder|WebsiteNavigationGroup whereCreatedAt($value)
 * @method static Builder|WebsiteNavigationGroup whereDeletedAt($value)
 * @method static Builder|WebsiteNavigationGroup whereId($value)
 * @method static Builder|WebsiteNavigationGroup whereName($value)
 * @method static Builder|WebsiteNavigationGroup wherePosition($value)
 * @method static Builder|WebsiteNavigationGroup whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static \Illuminate\Database\Query\Builder|WebsiteNavigationGroup onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|WebsiteNavigationGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|WebsiteNavigationGroup withoutTrashed()
 */
class WebsiteNavigationGroup extends Model
{
    use HasFactory, SoftDeletes;
}
