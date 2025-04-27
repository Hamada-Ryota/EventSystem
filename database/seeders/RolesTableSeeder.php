<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => '一般ユーザー', 'description' => '通常のユーザー'],
            ['name' => 'イベント主催者', 'description' => 'イベントを作成・管理できるユーザー'],
            ['name' => '管理者', 'description' => '全機能にアクセスできる管理ユーザー'],
        ]);
    }
}
