<?php

namespace App\Http\Controllers\Api\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Permission\Role;
use App\Models\User;
use App\Models\Website\WebsiteUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return array
     */
    public function login(Request $request): array
    {
        if ($request->isJson()) {
            $username = $request->json()->get('user');
            $password = $request->json()->get('password');
            $info = $request->json()->get('info');

            if (!is_null($username) && !is_null($password)) {
                $user = User::select()
                    ->where('username', $username)
                    ->orWhere('email', $username)
                    ->first();
                if ($user !== null) {
                    /** @var User $user */
                    if (Auth::attempt(['email' => $user->email, 'password' => $password])) {
                        return [
                            "success" => true,
                            "message" => "",
                            "token" => $user->createToken('auth')->plainTextToken,
                            "user" => $user->getStandardColumns('id'),
                            "info" => is_null($info) ? [] : WebsiteUtility::getExtraInfo($info, $user),
                        ];
                    }
                }
            }
            return [
                'success' => false,
                'message' => 'Invalid username or password',
            ];
        }
        return [
            'success' => false,
            'message' => 'Invalid Request',
        ];

    }

    /**
     *
     *
     * @param Request $request
     * @return array
     */
    public function fresh(Request $request): array
    {
        $user = Auth::user();
        $info = $request->isJson() ? $request->json()->get('info') : null;

        if ($user) {
            return [
                "success" => true,
                "message" => "",
                "user" => $user->getStandardColumns('id'),
                "info" => is_null($info) ? [] : WebsiteUtility::getExtraInfo($info, $user),
            ];
        } else {
            return [
                "success" => false,
                "message" => "Unauthenticated",
            ];
        }

    }

}
