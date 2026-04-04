<x-guest-layout>
  <div class="login_container">
    <div class="atlas_logo">
      <img src="{{ asset('image/atlas-black.png') }}" alt="Atlas Logo">
    </div>

    <div class="login_box">
      <form action="{{ route('loginPost') }}" method="POST">
        @csrf

        <p>メールアドレス</p>
        <input type="text" name="mail_address" required>

        <p>パスワード</p>
        <input type="password" name="password" required>

        <div class="login_btn_area">
          <input type="submit" class="login_btn" value="ログイン">
        </div>

        <a href="{{ route('registerView') }}" class="registration_link">新規登録はこちら</a>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="{{ asset('js/register.js') }}" rel="stylesheet"></script>
</x-guest-layout>
