<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }
    // 1つの投稿は、たくさんの「いいね」を持っています
    // Likeモデルと1対多の関係（一つの投稿に対して複数のいいねがつく）
    public function likes(){
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id');
}

    // サブカテゴリーのリレーション
    public function subCategories(){
    // 中間テーブル（post_sub_categories）を経由してサブカテゴリーを取得する設定
        return $this->belongsToMany('App\Models\Categories\SubCategory', 'post_sub_categories', 'post_id', 'sub_category_id');
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
