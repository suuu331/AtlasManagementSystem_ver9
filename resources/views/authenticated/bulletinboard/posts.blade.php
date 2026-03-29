<x-sidebar>
<div class="board_area w-100 border m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 m-auto p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>

      {{-- ★カテゴリー表示（設計書通りにサブカテゴリーを表示する） --}}
      <div class="mt-2">
        @if($post->subCategory)
          <span class="badge badge-info">{{ $post->subCategory->sub_category }}</span>
        @endif
      </div>

      <div class="post_bottom_area d-flex mt-2">
        <div class="d-flex post_status">
          <div class="mr-5">
            <i class="fa fa-comment"></i>
            <span class="">{{ $post->postComments->count() }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
              <i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}" style="color: red;"></i>
            @else
              <i class="fas fa-heart like_btn" post_id="{{ $post->id }}" style="color: gray;"></i>
            @endif
            <span class="like_counts{{ $post->id }}">{{ $post->likes->count() }}</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>


 <div class="other_area border w-25">
    <div class="border m-4 p-2">
      <div class="mb-2"><a href="{{ route('post.input') }}" class="btn btn-primary w-100">投稿</a></div>
      <div class="d-flex mb-2">
        <input type="text" class="w-75" placeholder="キーワードを検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="w-25" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="btn btn-secondary w-100 mb-2" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="btn btn-secondary w-100 mb-2" value="自分の投稿" form="postSearchRequest">

      <p class="mt-4">カテゴリー</p>
      <div class="category_menu">
        @foreach($categories as $category)
          {{-- メインカテゴリー --}}
          <div class="main_category border-bottom mb-1" style="cursor: pointer;">
            <span>{{ $category->main_category }}</span>
          </div>
          {{-- サブカテゴリーリスト --}}
          <div class="sub_category_list mb-2" style="display: none; padding-left: 15px;">
            @foreach($category->subCategories as $sub)
              <div class="sub_category_item">
              {{-- ★修正：inputからbuttonに変えて、valueをIDに --}}
              <button type="submit" name="category_word" value="{{ $sub->id }}" form="postSearchRequest" class="btn btn-link p-0" style="font-size: 13px;">
                {{ $sub->sub_category }}
              </button>
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>



<!-- JavaScriptの部分 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
  // 1. カテゴリー開閉
  $('.main_category').click(function () {
    $(this).next('.sub_category_list').slideToggle();
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
      _this.addClass('un_like_btn').removeClass('like_btn').css('color', 'red');
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
      _this.addClass('like_btn').removeClass('un_like_btn').css('color', 'gray');
      var count = $('.like_counts' + post_id).text();
      $('.like_counts' + post_id).text(parseInt(count) - 1);
    });
  });
});
</script>

</x-sidebar>
