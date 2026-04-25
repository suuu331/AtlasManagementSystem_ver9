<x-sidebar>
  <div class="main-container">
    <div class="board_wrapper">

      {{-- 左側：投稿一覧エリア --}}
      <div class="left_container">
        @foreach($posts as $post)
          <div class="post_area">
            {{-- 投稿者 --}}
            <p class="contributor">
              {{ $post->user->over_name }}{{ $post->user->under_name }}さん
            </p>
            {{-- 投稿タイトル --}}
            <p class="post_title">
              <a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a>
            </p>

            {{-- 下部エリア：CSSの justify-content: space-between が効く構造 --}}
      <div class="post_bottom_area mt-3">
        {{-- 左下：カテゴリー --}}
  <div class="bottom_left">
    {{-- ★sをつけて subCategories にし、最初の1つを表示するようにします --}}
    @if($post->subCategories->first())
      <span class="category_box">{{ $post->subCategories->first()->sub_category }}</span>
    @endif
  </div>

  {{-- 右下：アイコン --}}
  <div class="bottom_right d-flex post_status">
    <div class="mr-3">
      <i class="fa fa-comment"></i>
      <span>{{ $post->postComments->count() }}</span>
    </div>
    <div>
      @if(Auth::user()->is_Like($post->id))
        <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i>
      @else
        <i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i>
      @endif
      <span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span>
                </div>
              </div> {{-- bottom_rightの閉じ --}}
            </div> {{-- post_bottom_areaの閉じ --}}
          </div> {{-- post_areaの閉じ --}}
        @endforeach
      </div>

      {{-- 右側：メニューエリア --}}
      <div class="right_container">
        <a href="{{ route('post.input') }}" class="btn btn-primary w-100 mb-3">投稿</a>

        <div class="search_area d-flex mb-3">
          <input type="text" class="form-control" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
          <input type="submit" class="btn btn-info ml-1" value="検索" form="postSearchRequest">
        </div>

        <div class="btn_flex_container mb-4">
          <input type="submit" name="like_posts" class="btn btn-like" value="いいねした投稿" form="postSearchRequest">
          <input type="submit" name="my_posts" class="btn btn-my-post" value="自分の投稿" form="postSearchRequest">
        </div>

        <p class="mb-2">カテゴリー検索</p>
        <div class="category_area">
          @foreach($categories as $category)
            <div class="main_category d-flex justify-content-between js-accordion-title" style="cursor: pointer;">
              <span>{{ $category->main_category }}</span>
              <i class="fas fa-chevron-down"></i>
            </div>
            <div class="sub_category_list" style="display: none;">
              @foreach($category->subCategories as $sub)
                <div class="sub_category_item">
                  <button type="submit" name="category_word" value="{{ $sub->id }}" form="postSearchRequest" class="btn btn-link p-0 text-dark" style="text-decoration: none;">
                    {{ $sub->sub_category }}
                  </button>
                </div>
              @endforeach
            </div>
          @endforeach
        </div>
      </div>

      <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
    </div>
  </div>


 <!-- JavaScriptの部分 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
  // 1. カテゴリー開閉
  $('.js-accordion-title').click(function () { // クラス名を揃えました
    $(this).next('.sub_category_list').slideToggle();
    $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
  });

  // 2. いいね登録
  $(document).on('click', '.like_btn', function (e) {
    var _this = $(this);
    var post_id = _this.attr('post_id');
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/like/post/" + post_id,
      data: { post_id: post_id },
    }).done(function (res) {
      // ✅ .css() を消しました。これでCSSファイルの赤色が反映されます
      _this.addClass('un_like_btn').removeClass('like_btn');
      var count = $('.like_counts' + post_id).text();
      $('.like_counts' + post_id).text(parseInt(count) + 1);
    });
  });

  // 3. いいね解除
  $(document).on('click', '.un_like_btn', function (e) {
    var _this = $(this);
    var post_id = _this.attr('post_id');
    $.ajax({
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      method: "post",
      url: "/unlike/post/" + post_id,
      data: { post_id: post_id },
    }).done(function (res) {
      // ✅ .css() を消しました。これでCSSファイルのグレーが反映されます
      _this.addClass('like_btn').removeClass('un_like_btn');
      var count = $('.like_counts' + post_id).text();
      $('.like_counts' + post_id).text(parseInt(count) - 1);
    });
  });
});
</script>

</x-sidebar>
