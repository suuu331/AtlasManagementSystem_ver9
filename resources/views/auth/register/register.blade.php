<x-guest-layout>
  <div class="login_container"> <div class="login_box" style="width: 550px;"> <form action="{{ route('registerPost') }}" method="POST">
        @csrf

        <div class="register_flex">
          <div class="input_group">
            @error('over_name') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
            <p>姓</p>
            <input type="text" name="over_name" value="{{ old('over_name') }}">
          </div>
          <div class="input_group">
            @error('under_name') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
            <p>名</p>
            <input type="text" name="under_name" value="{{ old('under_name') }}">
          </div>
        </div>

        <div class="register_flex">
          <div class="input_group">
            @error('over_name_kana') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
            <p>セイ</p>
            <input type="text" name="over_name_kana" value="{{ old('over_name_kana') }}">
          </div>
          <div class="input_group">
            @error('under_name_kana') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
            <p>メイ</p>
            <input type="text" name="under_name_kana" value="{{ old('under_name_kana') }}">
          </div>
        </div>

        @error('mail_address') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
        <p>メールアドレス</p>
        <input type="email" name="mail_address" value="{{ old('mail_address') }}">

        <div class="radio_group">
          @error('sex') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
          <div class="radio_options mt-2">
            <input type="radio" name="sex" value="1" id="male"><label for="male" class="mr-3">男性</label>
            <input type="radio" name="sex" value="2" id="female"><label for="female" class="mr-3">女性</label>
            <input type="radio" name="sex" value="3" id="other"><label for="other">その他</label>
          </div>
        </div>

        <div class="birth_group mt-3">
          <p>生年月日</p>
          <select class="old_year" name="old_year">
            <option value="none">-----</option>
            @for($i = 1985; $i <= 2010; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
            @endfor
          </select> 年
          <select class="old_month" name="old_month">
            <option value="none">-----</option>
            @for($i = 1; $i <= 12; $i++)
            <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
            @endfor
          </select> 月
          <select class="old_day" name="old_day">
            <option value="none">-----</option>
            @for($i = 1; $i <= 31; $i++)
            <option value="{{ sprintf('%02d', $i) }}">{{ $i }}</option>
            @endfor
          </select> 日
        </div>

        <div class="radio_group mt-4">
          <p>役職</p>
          <div class="radio_options mt-2">
            <input type="radio" name="role" value="1" id="admin_ja"><label for="admin_ja" class="mr-2">教師(国語)</label>
            <input type="radio" name="role" value="2" id="admin_math"><label for="admin_math" class="mr-2">教師(数学)</label>
            <input type="radio" name="role" value="3" id="admin_en"><label for="admin_en" class="mr-2">教師(英語)</label>
            <input type="radio" name="role" value="4" id="student"><label for="student">生徒</label>
          </div>
        </div>

        <div class="select_teacher d-none mt-3">
          <p>選択科目</p>
          @foreach($subjects as $subject)
          <div class="d-inline-block mr-3">
            <input type="checkbox" name="subject[]" value="{{ $subject->id }}" id="subject_{{ $subject->id }}">
            <label for="subject_{{ $subject->id }}">{{ $subject->subject }}</label>
          </div>
          @endforeach
        </div>

        <div class="mt-4">
          @error('password') <span class="error_message" style="color:red; display:block;">{{ $message }}</span> @enderror
          <p>パスワード</p>
          <input type="password" name="password">
        </div>

        <div class="mt-4">
          <p>確認用パスワード</p>
          <input type="password" name="password_confirmation">
        </div>

        <div class="login_btn_area mt-5">
          <input type="submit" class="login_btn register_btn" value="新規登録" onclick="return confirm('登録してよろしいですか？')">
        </div>

        <div class="text-center mt-3">
          <a href="{{ route('loginView') }}" class="registration_link">ログインはこちら</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="{{ asset('js/register.js') }}"></script>
</x-guest-layout>
