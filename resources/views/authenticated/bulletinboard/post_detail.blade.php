<x-sidebar>
  <div class="main-container">
    <div class="board_wrapper">
      <div class="left_container">
        {{-- クラスを post_create_area に変える 新規投稿画面と同じ綺麗な白枠になる --}}
        <div class="post_create_area">

          {{-- 指示通り：バリデーションを一番上に --}}
          @error('post_title')
            <span class="error_message">{{ $message }}</span>
          @enderror

          <div class="detail_inner_head d-flex justify-content-between align-items-start">
            {{-- カテゴリー表示：sを付けて first() で取得 --}}
            <div>
              @if($post->subCategories->first())
                <span class="category_box">{{ $post->subCategories->first()->sub_category }}</span>
              @endif
            </div>
            {{-- 編集・削除ボタン --}}
            <div>
              @if($post->user_id == Auth::id())
                <span class="edit-modal-open btn btn-primary btn-sm" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
                {{-- btn-dangerは赤色になります --}}
                <a href="{{ route('post.delete', ['id' => $post->id]) }}" class="btn btn-danger btn-sm" onclick="return confirm('本当に削除しますか？')">削除</a>
              @endif
            </div>
          </div>

          <div class="contributor mt-2">
            <p>
              <span class="font-weight-bold" style="color: #333;">{{ $post->user->over_name }}{{ $post->user->under_name }}</span> さん
              <span class="ml-3 text-secondary" style="font-size: 11px;">{{ optional($post->created_at)->format('Y/m/d') }}</span>
            </p>
          </div>
          <div class="detsail_post_title font-weight-bold mt-2" style="font-size: 16px;">{{ $post->post_title }}</div>
          <div class="mt-3 detsail_post" style="color: #666;">{{ $post->post }}</div>

          {{-- コメント一覧 --}}
          <div class="comment_list_area mt-5">
            <p class="border-bottom pb-1" style="font-size: 14px;">コメント</p>
            @foreach($post->postComments as $comment)
            <div class="comment_area border-bottom py-2">
              <p class="contributor mb-1" style="font-size: 11px; color: #999;">
                {{ $comment->commentUser($comment->user_id)->over_name }}{{ $comment->commentUser($comment->user_id)->under_name }} さん
              </p>
              <p class="mb-0" style="font-size: 13px;">{{ $comment->comment }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="right_container">
        {{-- ★ここもクラスを category_area にすると統一感が出ます --}}
        <div class="category_area">
          @error('comment')
            <span class="error_message">{{ $message }}</span>
          @enderror
          <p class="mb-1">コメントする</p>

          <textarea class="w-100 mb-2" name="comment" form="commentRequest"></textarea>
          <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
          <input type="submit" class="btn btn-primary w-100" form="commentRequest" value="投稿">
          <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
        </div>
      </div>
    </div>
  </div>
</x-sidebar>
