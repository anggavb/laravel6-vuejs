<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    // Mengambil semua artikel
    public function index()
    {
        $articles = Article::orderBy('title', 'asc')->paginate(5);
        return ArticleResource::collection($articles);
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

    // Membuat artikel baru
    public function store(Request $request)
    {
        $article = Article::create($request->all());
        return new ArticleResource($article);
    }

    // Mengambil satu artikel (berdasarkan id)
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    // Mengubah artikel
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());
        return new ArticleResource($article);
    }

    // Menghapus artikel
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article->delete()) {
            return new ArticleResource($article);
        }
    }
}
