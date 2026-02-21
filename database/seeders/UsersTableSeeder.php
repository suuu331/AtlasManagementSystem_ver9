<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ログイン用初期ユーザー登録作成
        \DB::table('users')->insert([
        'over_name' => '山田',
        'under_name' => '太郎',
        'over_name_kana' => 'ヤマダ',
        'under_name_kana' => 'タロウ',
        'mail_address' => 'test@example.com', // emailではない
        'sex' => 1, // 1:男性 2:女性 など
        'birth_day' => '2000-01-01',
        'role' => 1, // 1:管理者 2:教師 3:生徒 など
        'password' => bcrypt('12345aabb'), // パスワードは暗号化
        'created_at' => now(),
    ]);

    }
}
