<?php

namespace App\Http\Controllers;

use App\Models\Memo;
use App\Models\MemoTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ここで各IDでかつ、削除されていないメモを取得→AppServiceProvider.phpに書いてる。
  
        // dd($memos);

        $tags = Tag::where('user_id', '=', Auth::id())
        ->whereNull('deleted_at')
        ->orderBy('id','DESC')
        ->get();
        // dd($tags);


        return view('create',compact('tags'));
    }

    // ※※※↓デプロイするためコメントアウトしました。※※※
    //     public function store(Request $request)
    //     {
    //         $posts = $request->all();
    //         // ddはdump dieの略→メソッドの引数にとった値を展開して止める→データの確認をするデバック関数↓
    //         // dd($posts);
    //         // dd(Auth::id());

    //         // 'content'はView(create.blade.php)のname属性のcontent
    //         $request->validate(['content' => 'required']);

    //          // ===== ここからトランザクション開始 ======
    //          DB::transaction(function() use($posts) {
    //          // １、メモIDをインサートして取得
    //             $memo_id = Memo::insertGetId([
    //                 'content' => $posts['content'],
    //                 'user_id' => Auth::id()
    //             ]);
    //             $tag_exists = Tag::where('user_id', '=', Auth::id())
    //             ->where('name', '=', $posts['new_tag'])
    //             ->exists();
    //         // 新規タグが入力されているかチェックするのと同時に、
    //         // 新規タグが既にtagsテーブルに存在するのかもチェック(タグのチェックをしないと同じ名前のタグが複数存在してしまう為)
    //             if( !empty($posts['new_tag']) && !$tag_exists ) {
    //         // ↑の新規タグが既に存在しなければ、tagsテーブルにインサート→IDを取得
    //                 $tag_id = Tag::insertGetId([
    //                     'user_id' => Auth::id(),
    //                     'name' => $posts['new_tag']
    //                 ]);
    //         // memo_tagsにインサートして、メモとタグを紐付ける
    //                 MemoTag::insert([
    //                     'memo_id' => $memo_id,
    //                     'tag_id' => $tag_id]);
    //             }
    //         // 既存タグが紐付けられた場合→memo_tagsにインサート
    //         foreach($posts['tags'] as $tag){
    //             MemoTag::insert(['memo_id' => $memo_id,
    //              'tag_id' => $tag]);
    //         }

    //          });
    //         //    ===== ここまでがトランザクションの範囲 ======

    //         return redirect( route('home'));
    //     }
    //     public function edit($id)
    //     {
    //         // ↓のはindexのままでいい。そうしないとエラーが起きる。→AppServiceProvider.phpに書いてる。

    //         $edit_memo = Memo::select('memos.*', 'tags.id AS tag_id')
    //             ->leftJoin('memo_tags', 'memo_tags.memo_id', '=', 'memos.id')
    //             ->leftJoin('tags', 'memo_tags.tag_id', '=', 'tags.id')
    //             ->where('memos.user_id', '=', Auth::id())
    //             ->where('memos.id', '=', $id)
    //             ->whereNull('memos.deleted_at')
    //             ->get();

    //         $include_tags = [];
    //         foreach($edit_memo as $memo) {
    //             array_push($include_tags, $memo['tag_id']);
    //         }
    //         //dd($include_tags);

    //         $tags = Tag::where('user_id', '=', Auth::id())
    //         ->whereNull('deleted_at')
    //         ->orderBy('id', 'DESC')
    //         ->get();

    //         return view('edit', compact('edit_memo', 'include_tags','tags'));
    //     }
    //     public function update(Request $request)
    //     {
    //         $posts = $request->all();

    //         // dd($posts);

    //         $request->validate(['content' => 'required']);

    //         // トランザクションスタート
    //         DB::transaction(function () use($posts){
    //             Memo::where('id', $posts['memo_id'])
    //             ->update([
    //                 'content' => $posts['content']
    //             ]);
    //         // 一旦メモとタグの紐付けを解除
    //             MemoTag::where('memo_id','=', $posts['memo_id'])->delete();
    //         // 再度メモとタグの紐付け
    //             foreach($posts['tags'] as $tag){
    //                 MemoTag::insert(['memo_id' => $posts['memo_id'],
    //                 'tag_id' => $tag]);
    //             }
    //             // もし、新しいタグの入力があれば、インサートして紐付ける
    //             $tag_exists = Tag::where('user_id', '=', Auth::id())
    //             ->where('name', '=', $posts['new_tag'])
    //             ->exists();
    //             // 新規タグが入力されているかチェックするのと同時に、
    //             // 新規タグが既にtagsテーブルに存在するのかもチェック(タグのチェックをしないと同じ名前のタグが複数存在してしまう為)
    //             if (!empty($posts['new_tag']) && !$tag_exists) {
    //                 // ↑の新規タグが既に存在しなければ、tagsテーブルにインサート→IDを取得
    //                 $tag_id = Tag::insertGetId([
    //                     'user_id' => Auth::id(),
    //                     'name' => $posts['new_tag']
    //                 ]);
    //                 // memo_tagsにインサートして、メモとタグを紐付ける
    //                 MemoTag::insert([
    //                     'memo_id' => $posts['memo_id'],
    //                     'tag_id' => $tag_id
    //                 ]);
    //             }

    //         });
    // // トランザクションはここまで



    //         return redirect(route('home'));
    //     }

    // ※※※↓デプロイするためコメントアウトしました。※※※
    public function destory(Request $request)
    {
        $posts = $request->all();

        //dd($posts);

        // ↓ ->delete();と書いてしまうと「物理削除」になってしまう。今回は論理削除。
        Memo::where('id', $posts['memo_id'])->update(
            ['deleted_at' => date("Y-m-d H:i:s", time())]
        );

        return redirect(route('home'));
    }
}
