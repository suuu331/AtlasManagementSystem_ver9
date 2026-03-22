<?php
namespace App\Searchs;

use App\Models\Users\User;

class SelectNameDetails implements DisplayUsers{

  // 改修課題：選択科目の検索機能
  public function resultUsers($keyword, $category, $updown, $gender, $role, $subjects){
    if(is_null($gender)){
      $gender = ['1', '2', '3'];
    }else{
      $gender = array($gender);
    }
    if(is_null($role)){
      $role = ['1', '2', '3', '4'];
    }else{
      $role = array($role);
    }
    // 1. ユーザー取得の基本クエリ（科目リレーションをロード）
    $users = User::with('subjects')
    // 2. 名前・フリガナのあいまい検索
    ->where(function($q) use ($keyword){
      $q->Where('over_name', 'like', '%'.$keyword.'%')
      ->orWhere('under_name', 'like', '%'.$keyword.'%')
      ->orWhere('over_name_kana', 'like', '%'.$keyword.'%')
      ->orWhere('under_name_kana', 'like', '%'.$keyword.'%');
    })
    // 3. 性別・権限の絞り込み
    ->where(function($q) use ($role, $gender){
      $q->whereIn('sex', $gender)
      ->whereIn('role', $role);
    })
    // ★ 4.「選択科目」の絞り込みを追加
    ->whereHas('subjects', function($q) use ($subjects){
      $q->whereIn('subjects.id', $subjects);// 「チェックしたどれか1つでも」になる
    })
    // 5. 並び替え（名前のカナ順
    ->orderBy('over_name_kana', $updown)->get();
    return $users;
  }

}
