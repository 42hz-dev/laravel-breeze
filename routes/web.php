<?php

use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/articles/create', function () {
    return view('articles.create');
})->name('articles.create');

Route::post('/articles', function (Request $request) {

    /* 유효성 확인 */
    $attributes = $request->validate([
        'body' => 'required|string|max:255'
    ]);

    /* Articles Database 저장 */
    Article::create([
        'body' => $attributes['body'],
        'user_id' => Auth::id()
    ]);

    return 'success!';
})->name('articles.post');

Route::get('/articles', function () {
    /* 최신순 페이지네이션 적용 (User 객체 포함) */
    $articles = Article::with('user')->latest()->paginate(3);

    /* 기존 파라미터 유지 */
    $articles->withQueryString();

    /* 가존 파라미터 추가 */
    // $articles->appends(['filter' => 'name']);

    /* Carbon (현재 날짜, 시간) 관련 핸들링 */
    // dd(Carbon::now());

    return view('articles.index', ['articles' => $articles]);
})->name('articles.index');
