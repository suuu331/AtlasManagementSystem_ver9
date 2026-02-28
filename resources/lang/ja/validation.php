<?php

return [
    /* ルールごとのメッセージ（よく使うものに絞っています） */
    'required' => ':attributeは必須項目です。',
    'regex'    => ':attributeの形式が正しくありません。',
    'date'     => ':attributeには正しい日付を入力してください。',
    'after_or_equal' => ':attributeは:date以降の日付を指定してください。',
    'email'    => ':attributeの形式が正しくありません。',
    'min'      => [
        'string' => ':attributeは:min文字以上で入力してください。',
    ],
    'max'      => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'confirmed' => ':attributeが一致しません。',
    'unique'   => 'この:attributeは既に登録されています。',

    /* 項目名の日本語訳（ここが重要！） */
    'attributes' => [
        'over_name' => '姓',
        'under_name' => '名',
        'over_name_kana' => 'セイ',
        'under_name_kana' => 'メイ',
        'mail_address' => 'メールアドレス',
        'sex' => '性別',
        'old_year' => '年',
        'old_month' => '月',
        'old_day' => '日',
        'datetime_validation' => '生年月日',
        'role' => '権限',
        'password' => 'パスワード',
        'password_confirmation' => 'パスワード（確認）',

    ],
];
