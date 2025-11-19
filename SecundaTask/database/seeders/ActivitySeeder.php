<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $generateTree = function(int $level = 1, ?Activity $parentActitvity = null) use (&$generateTree)
        {
            $countOfChildren = rand(1,3);

            for ($i = 0; $i < $countOfChildren; $i++)
            {
                $activity = Activity::factory()->create([
                    'parent_id' => $parentActitvity?->id
                ]);

                $activity->path = $parentActitvity ? $parentActitvity->path . "." . $activity->id : (string)$activity->id;
                $activity->save();

                if ($level < 3)
                    $generateTree($level + 1, $activity);
            }
        };
        
        $generateTree();
    }
}
