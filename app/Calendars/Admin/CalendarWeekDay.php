<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    // 予約設定を取得（紐づいているユーザー情報も一緒に取得）
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left calendar_status_cell">';

    // 1部
    if($one_part){
      $count = $one_part->users->count();
      // ★0人なら「0」、1人以上なら「〇人」にする条件分岐
      $display_count = ($count === 0) ? '0' : $count . '人';

      // ★「1部」を span で囲み、その後に全角スペース（または半角スペース）を挟んでいます
      $html[] = '<p class="day_part m-0 pt-1"><span class="status_part">1部</span>&nbsp;&nbsp;<a href="'.route('calendar.admin.detail', ['date' => $ymd, 'part' => 1]).'" class="status_num">' . $display_count . '</a></p>';
    }

    // 2部
    if($two_part){
      $count = $two_part->users->count();
      $display_count = ($count === 0) ? '0' : $count . '人';

      $html[] = '<p class="day_part m-0 pt-1"><span class="status_part">2部</span>&nbsp;&nbsp;<a href="'.route('calendar.admin.detail', ['date' => $ymd, 'part' => 2]).'" class="status_num">' . $display_count . '</a></p>';
    }

    // 3部
    if($three_part){
      $count = $three_part->users->count();
      $display_count = ($count === 0) ? '0' : $count . '人';

      $html[] = '<p class="day_part m-0 pt-1"><span class="status_part">3部</span>&nbsp;&nbsp;<a href="'.route('calendar.admin.detail', ['date' => $ymd, 'part' => 3]).'" class="status_num">' . $display_count . '</a></p>';
    }

    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }

}
