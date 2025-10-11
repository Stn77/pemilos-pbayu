<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function x()
    {
        $data = User::role('pemilih')->get();
        dd($data);
    }
}
