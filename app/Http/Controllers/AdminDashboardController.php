<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return [
            'projects_shown' => Project::count(),
            'projects_hidden' => Project::hidden()->count(),
            "collected_amount" => Payment::where('is_paid', true)->sum('given_amount')
        ];
    }
}
