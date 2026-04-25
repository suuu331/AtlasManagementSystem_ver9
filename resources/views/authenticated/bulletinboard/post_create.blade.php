<x-sidebar>
  <div class="main-container">
    <!-- {{-- グレー背景の左上にタイトルを配置 --}} -->
    <!-- <p class="section_title">新規投稿作成</p> -->

    <div class="board_wrapper">
      {{-- 左側：メインの投稿作成フォーム --}}
      <div class="left_container">
        <div class="post_create_area p-5"> {{-- borderやw-50を削除 --}}

          <div class="mb-4">
            <p class="mb-0">カテゴリー</p>
            <select class="w-100" form="postCreate" name="post_category_id">
              @foreach($main_categories as $main_category)
                <optgroup label="{{ $main_category->main_category }}">
                  @foreach($main_category->subCategories as $sub_category)
                    <option value="{{ $sub_category->id }}">{{ $sub_category->sub_category }}</option>
                  @endforeach
                </optgroup>
              @endforeach
            </select>
          </div>

          <div class="mb-4">
            {{-- 指示通り：バリデーションをラベルの上に配置 --}}
            @error('post_title')
              <span class="error_message">{{ $message }}</span>
            @enderror
            <p class="mb-0">タイトル</p>
            <input type="text" class="w-100" form="postCreate" name="post_title" value="{{ old('post_title') }}">
          </div>

          <div class="mb-4">
            {{-- バリデーションをラベルの上に配置 --}}
            @error('post_body')
              <span class="error_message">{{ $message }}</span>
            @enderror
            <p class="mb-0">投稿内容</p>
            <textarea class="w-100" form="postCreate" name="post_body">{{ old('post_body') }}</textarea>
          </div>

          <div class="text-right">
            <input type="submit" class="btn btn-primary px-4" value="投稿" form="postCreate">
          </div>
          <form action="{{ route('post.create') }}" method="post" id="postCreate">{{ csrf_field() }}</form>
        </div>
      </div>

      {{-- 右側：管理者のみ表示されるカテゴリー追加エリア --}}
      @can('admin')
      <div class="right_container">
        <div class="category_area p-5"> {{-- borderやmt-5を削除 --}}

          <div class="mb-5">
            @error('main_category_name')
              <span class="error_message">{{ $message }}</span>
            @enderror
            <p class="m-0">メインカテゴリー</p>
            <input type="text" class="w-100" name="main_category_name" form="mainCategoryRequest">
            <input type="submit" value="追加" class="btn btn-primary w-100 mt-2" form="mainCategoryRequest">
            <form action="{{ route('main.category.create') }}" method="post" id="mainCategoryRequest">{{ csrf_field() }}</form>
          </div>

          <div>
            @error('main_category_id')
              <span class="error_message">{{ $message }}</span>
            @enderror
            @error('sub_category_name')
              <span class="error_message">{{ $message }}</span>
            @enderror
            <p class="m-0">サブカテゴリー</p>
            <select class="w-100 mb-2" name="main_category_id" form="subCategoryRequest">
              <option value="">---</option>
              @foreach($main_categories as $main_category)
                <option value="{{ $main_category->id }}">{{ $main_category->main_category }}</option>
              @endforeach
            </select>
            <input type="text" class="w-100" name="sub_category_name" form="subCategoryRequest">
            <input type="submit" value="追加" class="btn btn-primary w-100 mt-2" form="subCategoryRequest">
            <form action="{{ route('sub.category.create') }}" method="post" id="subCategoryRequest">{{ csrf_field() }}</form>
          </div>

        </div>
      </div>
      @endcan
    </div>
  </div>
</x-sidebar>
