<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('cities')->truncate();
        DB::table('regions')->truncate();

        $data = json_decode(file_get_contents(base_path('cities.json')), true);
        $cities = [];
        $regions = [];
        $i = 0;
        $region = null;
        foreach ($data as $key => $datum) {
            if (!$key) {
                $region = $data[$key]['region'];
                $regions[$i] = [
                    'name' => $region,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $cities[] = [
                    'name' => $datum['city'],
                    'region_id' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
            if ($key) {
                if ($region != $data[$key]['region']) {
                    $region = $data[$key]['region'];
                    $regions[$i+1] = [
                        'name' => $region,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                    $i++;
                }
                $cities[] = [
                    'name' => $datum['city'],
                    'region_id' => $i+1,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        DB::beginTransaction();
        City::query()->insert($cities);
        Region::query()->insert($regions);
        DB::commit();
    }
}