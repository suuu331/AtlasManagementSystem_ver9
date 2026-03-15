<x-sidebar>
  <!-- 予約詳細 -->
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-75 m-auto h-75 shadow p-4">
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>

    <div class="h-75 border" style="overflow-y: auto;">
      <table class="table table-striped">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">予約場所</th>
        </tr>
        {{-- コントローラーから送られてきた $reservePersons をループさせる --}}
        @foreach($reservePersons as $reserveSetting)
          @foreach($reserveSetting->users as $user)
          <tr class="text-center">
            <td class="w-25">{{ $user->id }}</td>
            <td class="w-25">{{ $user->over_name }}{{ $user->under_name }}</td>
            <td class="w-25">
              {{-- ユーザーが選択している科目を「予約場所」として表示 --}}
              @foreach($user->subjects as $subject)
                {{ $subject->subject }}
              @endforeach
            </td>
          </tr>
          @endforeach
        @endforeach
      </table>
    </div>
  </div>
</div>

</x-sidebar>
