<?php

namespace App\Providers;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
        //全てのメソッドが呼ばれる前に先に呼ばれるメソッド
        view()->composer('*', function ($view) {
            
        // 自分のメモ取得はMemoモデルに任せる
        // インスタンス化
        $memo_model = new Memo();
        
        // メモ取得
        $memos = $memo_model->getMyMemo();

        $tags = Tag::where('user_id', '=', Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            //↑タグの新しい順にしたいので、'id'にする。
            ->get();

        $view->with('memos', $memos)->with('tags', $tags);

        });
    }
    
}
