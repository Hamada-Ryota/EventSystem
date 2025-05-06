<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;

class EventsTableSeeder extends Seeder
{
    public function run(): void
    {
        Event::insert([
            [
                'title' => 'Laravel勉強会',
                'date' => '2025-05-10',
                'time' => '14:00',
                'location' => '東京',
                'category_id' => 1,
                'detail' => '初心者向けの勉強会です',
                'capacity' => 50,
                'status_id' => 1,
                'organizer_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Vue.js ワークショップ',
                'date' => '2025-05-12',
                'time' => '15:00',
                'location' => '大阪',
                'category_id' => 2,
                'detail' => 'ハンズオン形式のワークショップ',
                'capacity' => 30,
                'status_id' => 1,
                'organizer_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'IT交流会',
                'date' => '2025-05-18',
                'time' => '18:00',
                'location' => '名古屋',
                'category_id' => 3,
                'detail' => '業界横断の交流イベントです',
                'capacity' => 100,
                'status_id' => 1,
                'organizer_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
