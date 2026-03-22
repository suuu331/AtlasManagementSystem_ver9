<x-sidebar>
<div class="vh-100 pt-5" style="background:#ECF1F6;">
  <div class="border w-75 m-auto pt-5 pb-5" style="border-radius:5px; background:#FFF;">
    <div class="w-75 m-auto border" style="border-radius:5px;">

      <p class="text-center">{{ $calendar->getTitle() }}</p>
      <div class="">
        {!! $calendar->render() !!}
      </div>
    </div>
    <div class="text-right w-75 m-auto">
      <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
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
        <div class="w-100 d-flex">
          <a class="js-modal-close btn btn-primary d-inline-block" href="">閉じる</a>
          <input type="submit" class="btn btn-danger d-inline-block" value="キャンセル">
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
