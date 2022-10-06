<?php

namespace App\Http\Controllers;

use App\Helpers\OnaizaDuitku;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd(0 == true);
        // sdfds
        return response([
            'result' => 0 / 10000 * 100
        ]);
    }
}
