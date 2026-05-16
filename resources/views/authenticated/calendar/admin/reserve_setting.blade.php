<!-- 予約枠登録カレンダー の画面 -->
<x-sidebar>
<div class="calendar_main_container">
  <div class="calendar_inner_area">

    <div class="calendar_card_box">

      <p class="calendar_month_title">{{ $calendar->getTitle() }}</p>

      <div class="calendar_table_wrapper">
        {!! $calendar->render() !!}
      </div>

      <div class="calendar_btn_area">
        <input type="submit" class="btn_calendar_blue_submit" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
      </div>

    </div>

  </div>
</div>
</x-sidebar>
