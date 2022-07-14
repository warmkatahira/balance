<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '片平　貴順',
            'email' => 't.katahira@warm.co.jp',
            'password' => bcrypt('katahira134'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => 'ワーム　太郎',
            'email' => 'test@warm.co.jp',
            'password' => bcrypt('warm134'),
            'role_id' => 1,
            'base_id' => 2,
        ]);
        User::create([
            'name' => '村上　弘明',
            'email' => 'warm1@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => '大泉　一弘',
            'email' => 'warm2@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => '木村　康洋',
            'email' => 'warm3@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => '並木　拓',
            'email' => 'warm4@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => '村上　裕也',
            'email' => 'warm5@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => '五十嵐　一之',
            'email' => 'warm6@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
        User::create([
            'name' => '村上　克也',
            'email' => 'warm7@warm.co.jp',
            'password' => bcrypt('warm1111'),
            'role_id' => 1,
            'base_id' => 1,
        ]);
    }
}
