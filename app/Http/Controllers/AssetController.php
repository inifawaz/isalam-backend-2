<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function uploadImageProjectContent(Request $request)
    {

        $file = $request->file('files');
        $filename = now()->format('y_m_d_h_i_s') .  "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
        $file->move(public_path('assets/img/projects/content'), $filename);
        return response([
            'filename' => asset('assets/img/projects/content') . '/' . $filename
        ]);
    }
}
