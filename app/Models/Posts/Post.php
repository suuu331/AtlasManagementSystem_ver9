<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\SubCategory;// ★追加：SubCategoryモデルの居場所を教える

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
    public function likes(){
        // Likeモデルと1対多の関係（一つの投稿に対して複数のいいねがつく）
        return $this->hasMany('App\Models\Posts\Like', 'like_post_id');
}

    // 投稿に紐づくサブカテゴリーのリレーション
    public function subCategory(){
    return $this->belongsTo(SubCategory::class, 'post_category_id');
}

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }
}
