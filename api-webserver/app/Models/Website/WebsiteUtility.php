<?php

namespace App\Models\Website;

use App\Models\Helper\PermissionsHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class WebsiteUtility
{
    /**
     * @param string|array $info
     * @param User|null $user
     * @return array
     */
    static function getExtraInfo(string|array $info, ?User $user = null): array
    {
        if (is_string($info)) {
            $info = [$info];
        }
        if (is_null($user)) {
            $user = Auth::user();
        }
        $res = [];
        foreach ($info as $el_info) {
            switch ($el_info) {
                case 'navigation':
                    $res[$el_info] = (new WebsiteNavigation())->getAvailableFromUser($user);
                    break;
                case 'user_permissions':
                    $res[$el_info] = PermissionsHelper::getAllPermissions($user)->pluck('name');
                    break;
                case 'test':
                    $res[$el_info] = ['test'];
                    break;
            }
        }
        return $res;

    }

}
