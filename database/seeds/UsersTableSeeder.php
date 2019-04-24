<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Region;
use App\Models\Kind;
use App\Models\Tag;
use App\Models\Album;
use App\Models\Media;
use App\Models\Like;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $this->createRoles($faker);
        $this->createRegions($faker);
        $this->createKinds($faker);

        User::truncate();
        factory(User::class, 30)->create();

        Album::truncate();
        factory(Album::class, 50)->create()->each(function ($album) {
            $kindId = Kind::all()->random()->id;
            $album->kinds()->attach($kindId);
        });

        Media::truncate();
        factory(Media::class, 200)->create()->each(function ($media) {
            $kindId = Kind::all()->random()->id;
            $media->kinds()->attach($kindId);
        });

        Like::truncate();
        for ($i = 1; $i <= 500; $i++) {
            $rand = $faker->randomElement([0, 1]);

            if ($rand) {
                $likeableType = 'App\Models\Media';
                $likeableId = Media::all()->random()->id;
            } else {
                $likeableType = 'App\Models\Album';
                $likeableId = Album::all()->random()->id;
            }

            factory(Like::class, 1)->create([
                'likeable_id' => $likeableId,
                'likeable_type' => $likeableType,
            ]);
        }
    }

    public function createRoles($faker)
    {
        Role::truncate();
        $roles = ['Admin', 'Artist', 'Member'];

        foreach ($roles as $role) {
            factory(Role::class)->create([
                'name' => $role,
            ]);
        }
    }

    public function createRegions($faker)
    {
        Region::truncate();
        $regions = ['Việt Nam', 'Âu Mỹ', 'Hàn Quốc', 'Nhật Bản', 'Châu Á'];

        foreach ($regions as $region) {
            factory(Region::class)->create([
                'name' => $region,
            ]);
        }
    }

    public function createKinds($faker)
    {
        Kind::truncate();
        $kinds = ['Nhạc trẻ', 'Rap', 'Ballad', 'R&B', 'Dance'];

        foreach ($kinds as $kind) {
            factory(Kind::class)->create([
                'name' => $kind,
            ]);
        }
    }

    public function createTags($faker)
    {
        //
    }
}
