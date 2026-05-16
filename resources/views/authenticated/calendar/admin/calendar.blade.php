<!-- 【スクール予約】予約確認画面 -->
<x-sidebar>
<div class="calendar_main_container">
  <div class="calendar_inner_area">

    <div class="calendar_card_box">

      <p class="calendar_month_title">{{ $calendar->getTitle() }}</p>

      <div class="calendar_table_wrapper">
        {!! $calendar->render() !!}
      </div>

    </div> </div>
</div>
</x-sidebar>
