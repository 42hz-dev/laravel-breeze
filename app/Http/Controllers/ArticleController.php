<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Go To Article List View
    */
    public function index()
    {
        /* 최신순 페이지네이션 적용 (User 객체 포함) */
        $articles = Article::with('user')
            ->latest()
            ->paginate(3);

        /* 기존 파라미터 유지 */
        $articles->withQueryString();

        /* 가존 파라미터 추가 */
        // $articles->appends(['filter' => 'name']);

        /* Carbon (현재 날짜, 시간) 관련 핸들링 */
        // dd(Carbon::now());

        return view('articles.index', ['articles' => $articles]);
    }

    /**
     * Go To Create View
    */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Create Article
    */
    public function store(Request $request)
    {
        /* 유효성 확인 */
        $attributes = $request->validate([
            'body' => 'required|string|max:255'
        ]);

        /* Articles Database 저장 */
        Article::create([
            'body' => $attributes['body'],
            'user_id' => Auth::id()
        ]);

        return redirect()->route('articles.index');
    }

    /**
     * Go To Show (Detail) View
    */
    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);
    }

    /**
     * Go To Edit View
    */
    public function edit(Article $article)
    {
        return view('articles.edit', ['article' => $article]);
    }

    /**
     * Update Article
    */
    public function update(Request $request, Article $article)
    {
        /* 유효성 확인 */
        $attributes = $request->validate([
            'body' => 'required|string|max:255'
        ]);

        /* Articles Database 수정 */
        $article->update($attributes);

        return redirect()->route('articles.show', ['article' => $article]);
    }

    /**
     * Delete Article
    */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }
}
