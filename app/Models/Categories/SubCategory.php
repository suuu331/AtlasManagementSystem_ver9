<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];

    public function mainCategory(){
        // リレーションの定義
        // サブカテゴリーは1つのメインカテゴリーに属する
        return $this->belongsTo('App\Models\Categories\MainCategory', 'main_category_id');
    }

    public function posts(){
        // リレーションの定義
        // サブカテゴリーにはたくさんの投稿が紐づく
        // 第2引数はPostテーブルにある外部キー名に合わせてください
        return $this->hasMany('App\Models\Posts\Post', 'post_category_id');
    }
}
