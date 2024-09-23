<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\LaratrustSeeder;
use Modules\Geocode\Database\Seeders\GeocodeDatabaseSeeder;
use Modules\Board\Database\Seeders\BoardDatabaseSeeder;
use Modules\Banner\Database\Seeders\BannerDatabaseSeeder;
use Modules\Comment\Database\Seeders\CommentDatabaseSeeder;
use Modules\Hashtag\Database\Seeders\HashtagDatabaseSeeder;
use Modules\Hashtag\Entities\Hashtag;
use Modules\Like\Database\Seeders\LikeDatabaseSeeder;
use Modules\Review\Database\Seeders\ReviewDatabaseSeeder;
use Modules\Payment\Database\Seeders\PaymentDatabaseSeeder;
use Modules\Post\Database\Seeders\PostDatabaseSeeder;
use Modules\Profile\Database\Seeders\ProfileDatabaseSeeder;
use Modules\Reshare\Database\Seeders\ReshareDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GeocodeDatabaseSeeder::class);
        $this->call(LaratrustSeeder::class);
        $this->call(BoardDatabaseSeeder::class);
        $this->call(BannerDatabaseSeeder::class);
        $this->call(ReviewDatabaseSeeder::class);
        $this->call(PaymentDatabaseSeeder::class);
        $this->call(ProfileDatabaseSeeder::class);
        $this->call(PostDatabaseSeeder::class);
        $this->call(CommentDatabaseSeeder::class);
        $this->call(HashtagDatabaseSeeder::class);
        $this->call(LikeDatabaseSeeder::class);
        $this->call(ReshareDatabaseSeeder::class);
    }
}

