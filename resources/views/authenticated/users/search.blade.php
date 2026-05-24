<x-sidebar>
<div class="search_content">

  {{-- 左側：ユーザーカード一覧エリア --}}
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="one_person">
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}" class="user_card_name">
          <span>{{ $user->over_name }}</span>
          <span>{{ $user->under_name }}</span>
        </a>
      </div>
      <div>
        <span>カナ : </span>
        <span>({{ $user->over_name_kana }}</span>
        <span>{{ $user->under_name_kana }})</span>
      </div>
      <div>
        @if($user->sex == 1)
        <span>性別 : </span><span>男</span>
        @elseif($user->sex == 2)
        <span>性別 : </span><span>女</span>
        @else
        <span>性別 : </span><span>その他</span>
        @endif
      </div>
      <div>
        <span>生年月日 : </span><span>{{ $user->birth_day }}</span>
      </div>
      <div>
        @if($user->role == 1)
        <span>権限 : </span><span>教師(国語)</span>
        @elseif($user->role == 2)
        <span>権限 : </span><span>教師(数学)</span>
        @elseif($user->role == 3)
        <span>権限 : </span><span>講師(英語)</span>
        @else
        <span>権限 : </span><span>生徒</span>
        @endif
      </div>
      <div>
        @if($user->role == 4)
        <span>選択科目 :</span>
          @foreach($user->subjects as $subject)
            <span>{{ $subject->subject }}</span>
          @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>

  {{-- 右側：固定の検索バーエリア --}}
  <div class="search_area">
    <div class="search_box">
      <p class="search_label">検索</p>
      <input type="text" class="free_word" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">

      <p class="search_label">カテゴリ</p>
      <select form="userSearchRequest" name="category">
        <option value="name">名前</option>
        <option value="id">社員ID</option>
      </select>

      <p class="search_label">並び替え</p>
      <select name="updown" form="userSearchRequest">
        <option value="ASC">昇順</option>
        <option value="DESC">降順</option>
      </select>
    </div>

    {{-- 検索条件の追加（アコーディオン） --}}
    <div class="search_conditions_container">
      <p class="search_conditions js-search-toggle">
         <span>検索条件の追加</span>
         <i class="fas fa-chevron-down"></i>
      </p>
      <div class="search_conditions_inner">
        <div class="mb-3">
          <label class="d-block small">性別</label>
          <span>男</span><input type="radio" name="sex" value="1" form="userSearchRequest" class="mr-2">
          <span>女</span><input type="radio" name="sex" value="2" form="userSearchRequest" class="mr-2">
          <span>その他</span><input type="radio" name="sex" value="3" form="userSearchRequest">
        </div>
        <div class="mb-3">
          <label class="d-block small">権限</label>
          <select name="role" form="userSearchRequest">
            <option selected disabled>----</option>
            <option value="1">教師(国語)</option>
            <option value="2">教師(数学)</option>
            <option value="3">教師(英語)</option>
            <option value="4">生徒</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="d-block small">選択科目</label>
          <div class="subject_check_boxes">
            @foreach($subjects as $subject)
              <div class="d-inline-block mr-2">
                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}" form="userSearchRequest" id="subject_{{ $subject->id }}">
                <label for="subject_{{ $subject->id }}" class="small">{{ $subject->subject }}</label>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- ボタン類（★classを独自のものに変更しました） --}}
    <div class="search_buttons">
      <input type="submit" name="search_btn" value="検索" class="user_search_btn" form="userSearchRequest">
      <input type="reset" value="リセット" class="reset_btn" form="userSearchRequest">
    </div>
  </div>

  <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function () {
  $('.search_conditions_inner').hide();

  $('.js-search-toggle').off('click').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    var $inner = $(this).next('.search_conditions_inner');
    if ($inner.is(':animated')) { return false; }

    $inner.slideToggle(300);
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
  });

  $('.search_conditions_inner').on('click', function (e) {
    e.stopPropagation();
  });
});
</script>
</x-sidebar>
