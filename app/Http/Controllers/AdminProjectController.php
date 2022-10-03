<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminInformationItemResource;
use App\Http\Resources\AdminPaymentItemResource;
use App\Http\Resources\AdminPaymentSuccessfulResource;
use App\Http\Resources\AdminProjectDetailResource;
use App\Http\Resources\ProjectItemResource;
use App\Http\Resources\ReportItemResource;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $projects = Project::where('id', 'LIKE', '%' . $request->search . '%')->orWhere('name', 'LIKE', '%' . $request->search . '%')->orderBy('id', 'desc')->get();
            return response([
                'projects' => ProjectItemResource::collection($projects)
            ]);
        }

        return response([
            'projects' => ProjectItemResource::collection(Project::orderBy('id', 'desc')->get())
        ]);
    }

    public function show(Project $project)
    {


        return response([
            'project' => new AdminProjectDetailResource($project),
            'information' => AdminInformationItemResource::collection($project->information),
            "reports" => AdminInformationItemResource::collection($project->reports),
            "payments" => AdminPaymentSuccessfulResource::collection($project->paymentsSuccess),
            "categories" => Category::get(),
            "statistics" => [
                "collected_amount" => $project->payments->where('is_paid', true)->sum('given_amount'),
                'successful_payments' => $project->payments->where('is_paid', true)->count()
            ]
        ]);
    }
}
