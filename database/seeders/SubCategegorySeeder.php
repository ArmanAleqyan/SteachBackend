<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategegorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_categories')->truncate();

        DB::table('sub_categories')->insert([
            [
                'id' => 1,
                'category_id' => '2',
                'sub_category_name' => 'Экскаваторы',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'category_id' => '2',
                'sub_category_name' => 'Автобетоно насос',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'category_id' => '2',
                'sub_category_name' => 'Автокран',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'category_id' => '2',
                'sub_category_name' => 'Бетоновозы',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'category_id' => '2',
                'sub_category_name' => 'Бульдозеры',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'category_id' => '2',
                'sub_category_name' => 'Гидромолот',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' =>7,
                'category_id' => '2',
                'sub_category_name' => 'Катки',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'category_id' => '1',
                'sub_category_name' => 'Газель до 1 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'category_id' => '1',
                'sub_category_name' => 'Газель до 2 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'category_id' => '1',
                'sub_category_name' => 'Газель до 3.5 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'category_id' => '1',
                'sub_category_name' => 'Грузовик до 5 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'category_id' => '1',
                'sub_category_name' => 'Грузовик до 10 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 13,
                'category_id' => '1',
                'sub_category_name' => 'Грузовик до 20 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 14,
                'category_id' => '1',
                'sub_category_name' => 'Газель бортовая',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],            [
                'id' => 15,
                'category_id' => '1',
                'sub_category_name' => 'Газель до 3.5 т.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],            [
                'id' => 16,
                'category_id' => '1',
                'sub_category_name' => 'Длинный борт',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 17,
                'category_id' => '6',
                'sub_category_name' => 'Мусоровоз',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 18,
                'category_id' => '6',
                'sub_category_name' => 'Автоцистерна',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 19,
                'category_id' => '6',
                'sub_category_name' => 'Бытовая техника',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 20,
                'category_id' => '6',
                'sub_category_name' => 'Ассенизаторы',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 21,
                'category_id' => '6',
                'sub_category_name' => 'Коммунально - дорожные',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 22,
                'category_id' => '8',
                'sub_category_name' => 'Мини погрузчики',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 23,
                'category_id' => '8',
                'sub_category_name' => 'Мини экскаваторы',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 24,
                'category_id' => '8',
                'sub_category_name' => 'Мини самосвалы',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 25,
                'category_id' => '8',
                'sub_category_name' => 'Мини миксера',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
