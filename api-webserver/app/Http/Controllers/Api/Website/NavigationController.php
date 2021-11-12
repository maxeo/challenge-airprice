<?php

namespace App\Http\Controllers\Api\Website;

use App\Models\Website\WebsiteNavigation;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class NavigationController extends Controller
{
    /**
     * @return array
     */
    public function getAvailable(): array
    {
        return (new WebsiteNavigation())->getAvailableFromUser(Auth::user());

    }
}
