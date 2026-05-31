<x-sidebar>
<!-- 【スクール予約】予約画面（生徒が予約する画面） -->
<div class="calendar_main_container">
  <div class="calendar_inner_area">
    <div class="calendar_card_box">

      <p class="calendar_month_title">{{ $calendar->getTitle() }}</p>

      <div class="calendar_table_wrapper">
        {!! $calendar->render() !!}

        <div class="calendar_btn_area">
         <input type="submit" class="btn_calendar_blue_submit" value="予約する" form="reserveParts">
        </div>
      </div>

    </div>
  </div>
</div>


<!-- JavaScriptを追記 キャンセル確認のモーダル-->
<div class="modal js-modal">
  <div class="modal__bg js-modal-close"></div>
  <div class="modal__content">
    <form action="{{ route('deleteParts') }}" method="post">
      <div class="w-100">
        <p>予約日：<span class="modal-inner-date"></span></p>
        <p>予約時間：<span class="modal-inner-part"></span></p>
        <p>上記の予約をキャンセルしてもよろしいですか？</p>
        <input type="hidden" name="delete_date" value="" class="modal-inner-date-input">
        <div class="w-100 text-center mt-4">

  <a class="js-modal-close btn btn-primary d-inline-block mx-3" href="">閉じる</a>
  <input type="submit" class="btn btn-danger d-inline-block mx-3" value="キャンセル">

</div>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    // モーダルを開く
    $('.js-modal-open').on('click', function(){
        $('.js-modal').fadeIn();
        // ボタンからデータ（日付・部数）を取得
        var reserve_date = $(this).data('reserve_date');
        var reserve_part = $(this).data('reserve_part');
        // モーダル内のテキストとhiddenタグに値をセット
        $('.modal-inner-date').text(reserve_date);
        $('.modal-inner-part').text(reserve_part);
        $('.modal-inner-date-input').val(reserve_date);
        return false;
    });

    // モーダルを閉じる
    $('.js-modal-close').on('click', function(){
        $('.js-modal').fadeOut();
        return false;
    });
});
</script>
</x-sidebar>
