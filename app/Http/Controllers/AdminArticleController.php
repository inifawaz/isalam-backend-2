<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleItemResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AdminArticleController extends Controller
{
    public function index()
    {
        return response([
            'articles' => ArticleItemResource::collection(Article::orderBy('id', 'desc')->get())
        ]);
    }

    public function store(Request $request)
    {
        $article = new Article();
        if ($request->file('featured_image_url')) {
            $file = $request->file('featured_image_url');
            $filename = Str::slug($request->name, '_') . now()->format('Y_m_d_His') . "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
            $file->move(public_path('assets/img/projects/featured'), $filename);
            $article->featured_image_url = asset('assets/img/projects/featured') . '/' . $filename;
        }
        $article->user_id = Auth::user()->id;
        $article->topic_id = $request->topic_id;
        $article->content = $request->content;
        $article->save();



        return response([
            'message' => 'berhasil menambah artikel baru',
            'article' => $article
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response([
            'message' => 'berhasil menghapus artikel'
        ]);
    }

    public function show(Article $article)
    {
        return response([
            'article' => $article
        ]);
    }

    public function update(Article $article, Request $request)
    {

        $article->user_id = Auth::user()->id;
        if ($request->file('featured_image_url')) {
            $file = $request->file('featured_image_url');
            $filename = Str::slug($request->name, '_') . now()->format('Y_m_d_His') . "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
            $file->move(public_path('assets/img/articles/featured'), $filename);
            $article->featured_image_url = asset('assets/img/articles/featured') . '/' . $filename;
        }
        $article->topic_id = $request->topic_id;
        $article->content = $request->content;

        $article->is_shown = $request->is_shown;
        $article->save();

        return response([
            'message' => 'berhasil merubah article',
            'article' => $article
        ], 201);
    }
}
