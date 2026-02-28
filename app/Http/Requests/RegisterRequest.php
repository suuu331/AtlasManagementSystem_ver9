<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // ここをtrueに
    }

    public function rules()
    {
        return [
            // 姓・名（10文字以内）
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            // セイ・メイ（カタカナのみ・30文字以内）
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            // メール（100文字以内・重複NG）
            'mail_address' => 'required|email|max:100|unique:users,mail_address',
            // 性別（1,2,3以外無効）
            'sex' => 'required|in:1,2,3',
            // 生年月日（実在する日付か・2000/1/1〜今日まで）
            'old_year' => 'required',
            'old_month' => 'required',
            'old_day' => 'required',
            'datetime_validation' => 'date|after_or_equal:2000-01-01|before_or_equal:today',
            // 役割（講師・生徒など以外無効）
            'role' => 'required|in:1,2,3,4',
            // パスワード（8〜30文字・確認用と一致）
            'password' => 'required|string|min:8|max:30|confirmed',
        ];
    }


    // 年月日を合体させてチェックするための準備
    protected function prepareForValidation()
    {
        $this->merge([
            'datetime_validation' => $this->old_year . '-' . $this->old_month . '-' . $this->old_day,
        ]);
    }
}
