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
use App\Models\Follow;
use App\Models\Comment;
use App\Models\WeekyView;
use Carbon\Carbon;

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
        $this->createTags($faker);

        User::truncate();
        factory(User::class, 100)->create();
        factory(Follow::class, 300)->create();

        Album::truncate();
        factory(Album::class, 50)->create()->each(function ($album) use ($faker) {
            $kindId = Kind::all()->random()->id;
            $album->kinds()->attach($kindId);

            $tagId = Tag::all()->random()->id;
            $album->kinds()->attach($tagId);

            $album->comments()->createMany([
                [
                    'user_id' => User::all()->random()->id,
                    'content' => $faker->sentence,
                    'status' => 1,
                ],
                [
                    'user_id' => User::all()->random()->id,
                    'content' => $faker->sentence,
                    'status' => 1,
                ]
            ]);
        });

        Media::truncate();
        factory(Media::class, 2000)->create()->each(function ($media) use ($faker) {
            $kindId = Kind::all()->random()->id;
            $media->kinds()->attach($kindId);

            $tagId = Tag::all()->random()->id;
            $media->tags()->attach($tagId);

            $media->comments()->createMany([
                [
                    'user_id' => User::all()->random()->id,
                    'content' => $faker->sentence,
                    'status' => 1,
                ],
                [
                    'user_id' => User::all()->random()->id,
                    'content' => $faker->sentence,
                    'status' => 1,
                ]
            ]);
        });

        Like::truncate();
        for ($i = 1; $i <= 1000; $i++) {
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

        for ($i = 1; $i <= 1000; $i++) {
            $rand = 1;
            if ($rand) {
                $media = Media::all()->random();
                $commentableType = 'App\Models\Media';
                $commentableId = $media->id;
                $parentId = $media->comments->where('reply_id', 0)->first()->id;
            } else {
                $album = Album::all()->random();
                $commentableType = 'App\Models\Album';
                $commentableId = $album->id;
                $parentId = $album->comments->where('reply_id', 0)->first()->id;
            }

            factory(Comment::class, 1)->create([
                'commentable_id' => $commentableId,
                'commentable_type' => $commentableType,
                'reply_id' => $parentId,
            ]);
        }

        $mediaData = Media::orderBy('views', 'desc')->take(100)->get();

        foreach ($mediaData as $media) {
            $media->weekyViews()->create([
                'views' => $faker->numberBetween(100, 5000),
                'date' => Carbon::now(),
            ]);
            $media->weekyViews()->create([
                'views' => $faker->numberBetween(100, 5000),
                'date' => Carbon::now()->subWeek(1),
            ]);
            $media->weekyViews()->create([
                'views' => $faker->numberBetween(100, 5000),
                'date' => Carbon::now()->subWeek(2),
            ]);
        }

        $albumData = Album::orderBy('views', 'desc')->take(100)->get();

        foreach ($albumData as $album) {
            $album->weekyViews()->create([
                'views' => $faker->numberBetween(100, 1000),
                'date' => Carbon::now(),
            ]);
            $album->weekyViews()->create([
                'views' => $faker->numberBetween(100, 1000),
                'date' => Carbon::now()->subWeek(1),
            ]);
            $album->weekyViews()->create([
                'views' => $faker->numberBetween(100, 1000),
                'date' => Carbon::now()->subWeek(2),
            ]);
        }
    }

    public function createRoles($faker)
    {
        Role::truncate();
        $roles = ['Admin', 'Member', 'Artist'];

        foreach ($roles as $role) {
            factory(Role::class)->create([
                'name' => $role,
            ]);
        }
    }

    public function createRegions($faker)
    {
        Region::truncate();
        $regions = [
            [
                'name' => 'Việt Nam',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
            [
                'name' => 'Âu Mỹ',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
            [
                'name' => 'Hàn Quốc',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
            [
                'name' => 'Nhật Bản',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
            [
                'name' => 'Trung Quốc',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
            [
                'name' => 'Châu Á',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
            [
                'name' => 'Thái Lan',
                'cover_image' => '/frontend/images/region_kind/region_bg.jpg'
            ],
        ];

        foreach ($regions as $region) {
            factory(Region::class)->create($region);
        }
    }

    public function createKinds($faker)
    {
        Kind::truncate();
        $kinds = [
            [
                'name' => 'Nhạc trẻ',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
            [
                'name' => 'Rap',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
            [
                'name' => 'Pop&Ballad',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
            [
                'name' => 'R&B',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
            [
                'name' => 'Dance',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
            [
                'name' => 'Rock',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
            [
                'name' => 'Remix',
                'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
            ],
        ];

        foreach ($kinds as $kind) {
            factory(Kind::class)->create($kind);
        }
    }

    public function createTags($faker)
    {
        Tag::truncate();
        $tags = [
            'Mưa',
            'Buồn',
            'Nhẹ nhàng',
            'Thất tình',
            'Vui vẻ',
            'Nhớ',
            'Cafe',
            'Biển',
            'Nhớ',
            'Live',
            'Cover'
        ];

        foreach ($tags as $tag) {
            factory(Tag::class)->create([
                'name' => $tag
            ]);
        }
    }
}
