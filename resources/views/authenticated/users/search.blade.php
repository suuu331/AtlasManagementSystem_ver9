<x-sidebar>
<p>ユーザー検索</p>
<div class="search_content w-100 border d-flex">
  <div class="reserve_users_area">
    @foreach($users as $user)
    <div class="border one_person">
      <div>
        <span>ID : </span><span>{{ $user->id }}</span>
      </div>
      <div><span>名前 : </span>
        <a href="{{ route('user.profile', ['id' => $user->id]) }}">
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
        {{-- ★ここから追加 選択科目」を出す--}}
          @foreach($user->subjects as $subject)
            <span>{{ $subject->subject }}</span>
          @endforeach
        @endif
      </div>
    </div>
    @endforeach
  </div>

  <div class="search_area">
     {{-- キーワード・カテゴリ・並び替え --}}
    <div class="search_box">
      <p class="search_label">検索</p>
      <input type="text" class="free_word mb-3" name="keyword" placeholder="キーワードを検索" form="userSearchRequest">

      <p class="search_label">カテゴリ</p>
      <select form="userSearchRequest" name="category" class="mb-3">
        <option value="name">名前</option>
        <option value="id">社員ID</option>
      </select>

      <p class="search_label">並び替え</.>
      <select name="updown" form="userSearchRequest" class="mb-3">
        <option value="ASC">昇順</option>
        <option value="DESC">降順</option>
      </select>
    </div>

    {{-- 検索条件の追加（アコーディオン） --}}
    <div class="search_conditions_container">
     {{-- ここ（スイッチ部分）だけに js-search-toggle をつける --}}
      <p class="m-0 search_conditions js-search-toggle">
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
          <select name="role" form="userSearchRequest" class="w-100">
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

    {{-- ボタン類 --}}
    <div class="search_buttons">
      <input type="submit" name="search_btn" value="検索" class="btn btn-info w-100 mb-2" form="userSearchRequest">
      {{-- リセットを一番下に配置 --}}
      <input type="reset" value="リセット" class="reset_btn w-100" form="userSearchRequest">
    </div>
  </div>
    <form action="{{ route('user.show') }}" method="get" id="userSearchRequest"></form>
  </div>
</div>


<!-- jQueryを読み込む -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function () {
  // 1. まず、既存のクリックイベントをすべてクリアしてから登録する
  $('.js-search-toggle').off('click').on('click', function (e) {
    // aタグやsubmitのような挙動を完全に止める
    e.preventDefault();
    e.stopPropagation();

    var $inner = $(this).next('.search_conditions_inner');

    // 2. アニメーション中なら何もしない（連打防止）
    if ($inner.is(':animated')) {
      return false;
    }

    // 3. スライド開閉を実行
    $inner.slideToggle(300);

    // 4. 矢印の向きを切り替え
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
  });

  // 5. 中身をクリックしても親のイベントが発火しないようにする
  $('.search_conditions_inner').on('click', function (e) {
    e.stopPropagation();
  });
});
</script>
</x-sidebar>
