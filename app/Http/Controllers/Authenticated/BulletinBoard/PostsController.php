<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
    // 最新順に並べる条件を追加
    $query = Post::with('user', 'postComments', 'likes', 'subCategories')
                ->orderBy('created_at', 'desc');

    // キーワード検索（タイトル、本文、またはサブカテゴリー名との完全一致）
    if (!empty($request->keyword)) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('post_title', 'like', '%' . $keyword . '%')
              ->orWhere('post', 'like', '%' . $keyword . '%')
              // ★サブカテゴリー名と完全一致するか
              ->orWhereHas('subCategories', function($q_sub) use ($keyword) {
                  $q_sub->where('sub_category', $keyword);
              });
        });
    }

    // ★サイドバーのサブカテゴリーをクリックした時の絞り込み
    if (!empty($request->category_word)) {
        $query->whereHas('subCategories', function($q) use ($request) {
            $q->where('sub_category', $request->category_word);
        });
    }

    // いいねした投稿
    if ($request->like_posts) {
        $likes = Auth::user()->likePostId()->get('like_post_id');
        $query->whereIn('id', $likes);
    }

    // 自分の投稿
    if ($request->my_posts) {
        $query->where('user_id', Auth::id());
    }

    $posts = $query->get();
    $categories = MainCategory::with('subCategories')->get();

    return view('authenticated.bulletinboard.posts', compact('posts', 'categories'));
    }


    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        // メインカテゴリーと一緒に、紐づくサブカテゴリーも取得する
        $main_categories = MainCategory::with('subCategories')->get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }


    // サブカテゴリー
    public function postCreate(PostFormRequest $request){
        // バリデーションはRequestクラスが自動でやってくれるので、保存処理のみ
        Post::create([
            'user_id' => Auth::id(),
            'post_category_id' => $request->post_category_id, // ★ここを追加！
            'post_title' => $request->post_title,
            'post' => $request->post_body // フォームのname属性がpost_bodyの場合
        ]);

        return redirect()->route('post.show');
    }

    public function postEdit(Request $request){
        // 設計書の条件に基づいたバリデーションを追加
        $request->validate([
           'post_title' => 'required|string|max:100',
           'post_body' => 'required|string|max:2000',
        ]);
        // 自分の投稿であることを確認して更新
        Post::where('id', $request->post_id)
        ->update([
        'post_title' => $request->post_title,
        'post' => $request->post_body, // データベースの項目名に合わせて 'post' としています
        ]);

        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        // 自分の投稿のみ削除を許可 Post::findOrFail($id)->delete();
        Post::where('id', $id)
        ->delete();

        return redirect()->route('post.show');
    }

    public function mainCategoryCreate(Request $request){
        // バリデーション：必須、文字列、100文字以内、すでに登録されていないか
        $request->validate([
           'main_category_name' => 'required|string|max:100|unique:main_categories,main_category'
        ]);
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(Request $request){
       // バリデーション：メインカテゴリー選択必須、サブ名は必須・100字以内・重複不可
        $request->validate([
           'main_category_id' => 'required|exists:main_categories,id',
           'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category'
        ]);

        SubCategory::create([
           'main_category_id' => $request->main_category_id,
           'sub_category' => $request->sub_category_name
        ]);
        return redirect()->route('post.input');
    }

    // コメント投稿
    public function commentCreate(Request $request){
      // ★バリデーションを先頭に追加（messageはlang/ja/validation.phpから自動取得）
       $request->validate([
        'comment' => 'required|string|max:250',
    ]);

       PostComment::create([
        'post_id' => $request->post_id,
        'user_id' => Auth::id(),
        'comment' => $request->comment
    ]);

       return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    // いいねをつける処理
    public function postLike(Request $request){
    // Auth::user() は「ログインしている自分」
    // likes() は Userモデルで定義したリレーション（後述）
    // attach() は、中間テーブルにデータを1件追加する魔法のメソッド
     Auth::user()->likes()->attach($request->post_id);
    // 非同期通信（Ajax）への返事として、空のデータをJSON形式で返します
        return response()->json();
    }

    // いいねを外す処理
    public function postUnLike(Request $request){
    // detach() は、中間テーブルから特定のデータを削除するメソッドです
     Auth::user()->likes()->detach($request->post_id);
         return response()->json();
    }


}
