<?php

namespace Modules\Favorite\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Favorite\Entities\Favorite;
/**
 * Class FavoriteTableSeeder.
 */
class FavoriteSeeder extends Seeder
{
    /**
     * Run the database seed.
     */
    public function run(): void
    {
        Favorite::create([
            'user_id' => 3,
            'post_id' => 1
        ]);
        Favorite::create([
            'user_id' => 3,
            'post_id' => 2
        ]);
    }
}
