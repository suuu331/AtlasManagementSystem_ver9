<!-- 予約詳細確認画面（リスト） -->
<x-sidebar>
<div class="reserve_detail_container">
  <div class="reserve_detail_inner">

    <p class="reserve_detail_title">
      <span>{{ $date }}</span>
    </p>

    <div class="reserve_detail_card">
      <div class="table_scroll_area">
        <table class="reserve_people_table">
          <thead>
            <tr>
              <th class="col_id">ID</th>
              <th class="col_name">名前</th>
              <th class="col_place">場所</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reservePersons as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->over_name }}{{ $user->under_name }}</td>
              <td>リモート</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
</x-sidebar>
