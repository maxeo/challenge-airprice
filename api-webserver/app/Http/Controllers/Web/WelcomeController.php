<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Collection;

class WelcomeController extends Controller
{
    public function index()
    {
        return abort('403', 'Invalid API REQUEST');
    }

    public function test()
    {
        dd("test");

        die();
    }

}
