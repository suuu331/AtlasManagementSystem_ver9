<x-sidebar>
<div class="profile_main_container">
  <div class="profile_inner_area">

    <p class="profile_title">{{ $user->over_name }} {{ $user->under_name }}さんのプロフィール</p>

    <div class="user_status_box">
      <p>名前 : <span>{{ $user->over_name }} {{ $user->under_name }}</span></p>
      <p>カナ : <span>{{ $user->over_name_kana }} {{ $user->under_name_kana }}</span></p>
      <p>性別 : <span>{{ $user->sex == 1 ? '男' : '女' }}</span></p>
      <p>生年月日 : <span>{{ $user->birth_day }}</span></p>

      <div class="current_subjects">
        選択科目 :
        @foreach($user->subjects as $subject)
          <span class="subject_tag">{{ $subject->subject }}</span>
        @endforeach
      </div>

      {{-- アコーディオンエリア --}}
      @can('admin')
<div class="subject_accordion_wrapper">

  <div class="subject_toggle_text js-subject-toggle">
    <span>選択科目の登録</span>
    <i class="fas fa-chevron-down toggle_arrow"></i>
  </div>

  <div class="subject_inner">
    <form action="{{ route('user.edit') }}" method="post">
      @csrf
      <div class="checkbox_and_btn_row">

        @foreach($subject_lists as $subject_list)
        <div class="checkbox_item">
          <label for="subject_{{ $subject_list->id }}">{{ $subject_list->subject }}</label>
          <input type="checkbox" name="subjects[]" value="{{ $subject_list->id }}" id="subject_{{ $subject_list->id }}">
        </div>
        @endforeach

        <input type="submit" value="登録" class="btn_subject_blue_submit">

      </div>
      <input type="hidden" name="user_id" value="{{ $user->id }}">
    </form>
  </div>
</div>
@endcan

    </div>
  </div>
</div>


<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
  // 「選択科目の編集」がクリックされたとき
  $('.js-subject-toggle').on('click', function () {
    // 次にある中身（.subject_inner）をスライド開閉
    $(this).next('.subject_inner').stop(true, true).slideToggle(300);

    // 矢印の上下向きを切り替え
    $(this).find('.toggle_arrow').toggleClass('fa-chevron-down fa-chevron-up');
  });
});
</script>

</x-sidebar>
