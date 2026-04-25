<x-sidebar>
  <div class="main-container">
    <p class="section_title">投稿詳細</p>

    <div class="board_wrapper">
      <div class="left_container">
        <div class="detail_container p-3">
          <div class="detail_inner_head d-flex justify-content-between">
            {{-- カテゴリー表示 --}}
            <div>
              @if($post->subCategory)
                <span class="category_box">{{ $post->subCategory->sub_category }}</span>
              @endif
            </div>
            {{-- 編集・削除ボタン（自分の投稿のみ） --}}
            <div>
              @if($post->user_id == Auth::id())
                <span class="edit-modal-open btn btn-primary" post_title="{{ $post->post_title }}" post_body="{{ $post->post }}" post_id="{{ $post->id }}">編集</span>
                <a href="{{ route('post.delete', ['id' => $post->id]) }}" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">削除</a>
              @endif
            </div>
          </div>

          <div class="contributor mt-2">
            <p>
              <span class="font-weight-bold" style="color: #333;">{{ $post->user->over_name }}{{ $post->user->under_name }}</span> さん
              <span class="ml-3 text-secondary" style="font-size: 11px;">{{ $post->created_at }}</span>
            </p>
          </div>
          <div class="detsail_post_title font-weight-bold mt-2" style="font-size: 16px;">{{ $post->post_title }}</div>
          <div class="mt-3 detsail_post" style="color: #666;">{{ $post->post }}</div>

          {{-- コメント一覧表示 --}}
          <div class="comment_list_area mt-5">
            <p class="border-bottom pb-1">コメント</p>
            @foreach($post->postComments as $comment)
            <div class="comment_area border-bottom py-2">
              <p class="contributor mb-1" style="font-size: 11px;">
                <span>{{ $comment->commentUser($comment->user_id)->over_name }}{{ $comment->commentUser($comment->user_id)->under_name }}</span> さん
              </p>
              <p class="mb-0" style="font-size: 13px;">{{ $comment->comment }}</p>
            </div>
            @endforeach
          </div>
        </div>
      </div>

      <div class="right_container">
        <div class="comment_container p-3">
          @error('comment')
            <span class="error_message">{{ $message }}</span>
          @enderror
          <p class="mb-1">コメントする</p>

          <textarea class="w-100 form-control mb-2" name="comment" form="commentRequest" style="height: 150px; resize: none;"></textarea>
          <input type="hidden" name="post_id" form="commentRequest" value="{{ $post->id }}">
          <input type="submit" class="btn btn-primary w-100" form="commentRequest" value="投稿">
          <form action="{{ route('comment.create') }}" method="post" id="commentRequest">{{ csrf_field() }}</form>
        </div>
      </div>
    </div>
  </div>

  {{-- モーダル部分は元のままでOKですが、スタイルを整えるとより綺麗になります --}}
  <div class="modal js-modal">
    </div>

</x-sidebar>
