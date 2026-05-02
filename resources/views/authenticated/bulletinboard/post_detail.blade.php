<x-sidebar>
  <div class="main-container">
    <div class="board_wrapper">

      {{-- 左側：投稿詳細 --}}
      <div class="left_container">
        <div class="post_create_area">
          @error('post_title')
            <span class="error_message">{{ $message }}</span>
          @enderror

          <div class="detail_inner_head d-flex justify-content-between align-items-start">
            <div>
              @if($post->subCategories->first())
                <span class="category_box">{{ $post->subCategories->first()->sub_category }}</span>
              @endif
            </div>
            @if($post->user_id == Auth::id())
              <div>
                <span class="edit-modal-open btn btn-primary btn-sm" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
                <a href="{{ route('post.delete', ['id' => $post->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</a>
              </div>
            @endif
          </div>

          <div class="contributor mt-2">
            <p class="font-weight-bold">{{ $post->user->over_name }}{{ $post->user->under_name }} さん</p>
          </div>
          <div class="detsail_post_title font-weight-bold mt-2">{{ $post->post_title }}</div>
          <div class="mt-3 detsail_post text-secondary">{{ $post->post }}</div>

          {{-- コメント一覧 --}}
          <div class="comment_list_area mt-5">
            <p class="border-bottom pb-1">コメント</p>
            @foreach($post->postComments as $comment)
            <div class="comment_area border-bottom py-2">
              <p class="contributor mb-1" style="font-size: 11px; color: #999;">
                {{ $comment->commentUser($comment->user_id)->over_name }}{{ $comment->commentUser($comment->user_id)->under_name }} さん
              </p>
              <p class="mb-0 small">{{ $comment->comment }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      {{-- 右側：コメント入力 --}}
      <div class="right_container">
        <div class="category_area">
          @error('comment')
            <span class="error_message">{{ $message }}</span>
          @enderror
          <p class="mb-2">コメントする</p>
          <textarea name="comment" form="commentRequest" class="w-100 mb-2"></textarea>
          {{-- ★ボタンをこの div で囲むことで右下に配置されます --}}
          <div class="comment_submit_btn">
             <input type="submit" class="btn btn-primary" form="commentRequest" value="投稿">
          </div>

          <form action="{{ route('comment.create') }}" method="post" id="commentRequest">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- モーダル本体（HTML） --}}
  <div class="modal js-modal">
    <div class="modal__bg js-modal-close"></div>
    <div class="modal__content">
      <form action="{{ route('post.edit') }}" method="post">
        <div class="w-100">
          <div class="modal-inner-title w-100">
            <input type="text" name="post_title" placeholder="タイトル" class="w-100 modal_post_title">
          </div>
          <div class="modal-inner-body w-100 mt-3">
            <textarea name="post_body" placeholder="投稿内容" class="w-100 modal_post_body"></textarea>
          </div>
          {{-- ★「左右振り分け」に設定 --}}
          <div class="modal_btns">
            <a class="js-modal-close btn btn-danger" href="">閉じる</a>
            <input type="submit" class="btn btn-primary" value="更新">
          </div>
          <input type="hidden" name="post_id" class="modal_id">
        </div>
        @csrf
      </form>
    </div>
  </div>


  {{-- 編集ボタンを動かすためのJavaScript --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(function () {
      $('.edit-modal-open').on('click', function () {
        $('.js-modal').fadeIn();
        var post_title = $(this).attr('post_title');
        var post_body = $(this).attr('post_body');
        var post_id = $(this).attr('post_id');
        $('.modal_post_title').val(post_title);
        $('.modal_post_body').val(post_body);
        $('.modal_id').val(post_id);
        return false;
      });
      $('.js-modal-close').on('click', function () {
        $('.js-modal').fadeOut();
        return false;
      });
    });
  </script>
</x-sidebar>
