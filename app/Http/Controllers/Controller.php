<?php

namespace App\Http\Controllers;

use App\Models\Calon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function x()
    {
        $data = Calon::with('misi')->find(1);

        foreach ($data->misi as $misi) {
            echo $misi->misi . '<br>';
        }
    }
}
