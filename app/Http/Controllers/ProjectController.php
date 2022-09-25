<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminInformationItemResource;
use App\Http\Resources\BackerItemResource;
use App\Http\Resources\ProjectDetailResource;
use App\Http\Resources\ProjectItemResource;
use App\Http\Resources\ReportItemResource;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->type === 'limited-time') {
            return response([
                'projects' => ProjectItemResource::collection(Project::limitedTime()->orderBy('id', 'desc')->get())
            ]);
        } else if ($request->type === 'without-target-amount') {
            return response([
                'projects' => ProjectItemResource::collection(Project::withoutTargetAmount()->orderBy('id', 'desc')->get())
            ]);
        }

        return response([
            'projects' => ProjectItemResource::collection(Project::shown()->orderBy('id', 'desc')->get()),
            "categories" => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $project = new Project();
        $project->user_id = Auth::user()->id;
        if ($request->file('featured_image_url')) {
            $file = $request->file('featured_image_url');
            $filename = Str::slug($request->name, '_') . now()->format('Y_m_d_His') . "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
            $file->move(public_path('assets/img/projects/featured'), $filename);
            $project->featured_image_url = asset('assets/img/projects/featured') . '/' . $filename;
        }
        $project->name = $request->name;
        $project->category_id = $request->category_id;
        $project->description = $request->description;
        $project->location = $request->location;
        $project->instagram_url = $request->instagram_url;
        $project->facebook_url = $request->facebook_url;
        $project->twitter_url = $request->twitter_url;
        $project->maintenance_fee = $request->maintenance_fee;
        $project->is_target = $request->is_target;
        $project->target_amount = $request->target_amount;
        $project->first_choice_given_amount = $request->first_choice_given_amount;
        $project->second_choice_given_amount = $request->second_choice_given_amount;
        $project->third_choice_given_amount = $request->third_choice_given_amount;
        $project->fourth_choice_given_amount = $request->fourth_choice_given_amount;
        $project->is_limited_time = $request->is_limited_time;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->save();

        return response([
            'message' => 'berhasil menambahkan project baru',
            'project' => $project
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response([
            'project' => new ProjectDetailResource($project),
            'information' => ReportItemResource::collection($project->information),
            "reports" => ReportItemResource::collection($project->reports),
            "backers" => BackerItemResource::collection($project->paymentsSuccess)
            // "backers" => $project->transactions

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {


        $project->user_id = Auth::user()->id;
        if ($request->file('featured_image_url')) {
            $file = $request->file('featured_image_url');
            $filename = Str::slug($request->name, '_') . now()->format('Y_m_d_His') . "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
            $file->move(public_path('assets/img/projects/featured'), $filename);
            $project->featured_image_url = asset('assets/img/projects/featured') . '/' . $filename;
        }
        $project->name = $request->name;
        $project->category_id = $request->category_id;
        $project->description = $request->description;
        $project->location = $request->location;
        $project->instagram_url = $request->instagram_url;
        $project->facebook_url = $request->facebook_url;
        $project->twitter_url = $request->twitter_url;
        $project->maintenance_fee = $request->maintenance_fee;
        $project->is_target = $request->is_target;
        $project->target_amount = $request->target_amount;
        $project->first_choice_given_amount = $request->first_choice_given_amount;
        $project->second_choice_given_amount = $request->second_choice_given_amount;
        $project->third_choice_given_amount = $request->third_choice_given_amount;
        $project->fourth_choice_given_amount = $request->fourth_choice_given_amount;
        $project->is_limited_time = $request->is_limited_time;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->is_shown = $request->is_shown;
        $project->is_ended = $request->is_ended;
        $project->is_favourite = $request->is_favourite;
        $project->save();

        return response([
            'message' => 'berhasil merubah project',
            'project' => $project
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
