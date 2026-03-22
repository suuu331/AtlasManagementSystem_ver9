<?php
// 一般ユーザー（General）の予約画面用、関連メソッド

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }


    // 予約をキャンセル（削除）するための delete メソッド
    public function delete(Request $request){
        DB::beginTransaction();
        try{
            // モーダルから送られてきた日付を取得
            $delete_date = $request->delete_date;
            // ログインユーザーがその日に予約している設定（部数など）を取得
            $reserve_setting = Auth::user()->reserveSettings()->where('setting_reserve', $delete_date)->first();

            if($reserve_setting){
                // 1. 予約枠を1つ戻す
                $reserve_setting->increment('limit_users');
                // 2. 中間テーブルの紐付けを解除する
                $reserve_setting->users()->detach(Auth::id());
            }

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        // カレンダー画面へリダイレクト（ルート名はプロジェクトの設定に合わせてください）
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

}
