<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportStoreRequest;
use App\Http\Requests\ReportUpdateRequest;
use App\Http\Resources\AdminReportItemResource;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminReportController extends Controller
{
    public function destroy(Report $report)
    {
        $report->delete();
        return response([
            "message" => "laporan berhasil dihapus"
        ]);
    }
    public function update(ReportUpdateRequest $request, Report $report)
    {
        // $report = Report::findOrFail($request->id);
        $report->update([
            "content" => $request->content,
            "user_id" => Auth::user()->id
        ]);

        return response([
            "message" => "berhasil merubah laporan",
            "report" => $report
        ]);
    }
    public function index()
    {
        return response([
            "reports" => AdminReportItemResource::collection(Report::orderBy('id', 'desc')->get())
        ]);
    }
    public function store(ReportStoreRequest $request)
    {
        $report = Report::create([
            "user_id" => Auth::user()->id,
            "project_id" => $request->project_id,
            "content" => $request->content
        ]);

        return response([
            "message" => "berhasil membuat laporan baru",
            "report" => $report
        ], 201);
    }
}
