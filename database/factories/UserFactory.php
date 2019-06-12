<?php

use App\Models\User;
use App\Models\Media;
use App\Models\Role;
use App\Models\Region;
use App\Models\Kind;
use App\Models\Album;
use App\Models\Like;
use App\Models\Follow;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\WeekyView;

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 'admin', // password
        'remember_token' => Str::random(10),
        'avatar' => $faker->imageUrl(100, 100),
        'gender' => 3,
        'description' => '',
        'role_id' => $faker->randomElement([2, 3]),
        'background' => '',
        'status' => 1,
    ];
});

$factory->define(Album::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'region_id' => Region::all()->random()->id,
        'name' => implode(' ', $faker->words(3)),
        'cover_image' => $faker->imageUrl(640, 480),
        'status' => 1,
        'type' => $faker->randomElement([1, 2]),
        'views' => $faker->numberBetween(100, 10000),
    ];
});

$musicData = [
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui038/TongHua-Instrumental_6dqd.mp3?st=AY64i-XNHjnP7GhsKSa1Xg&amp;e=1559860780&amp;download=true',
        'name' => 'Tong Hua'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui956/EndlessLove-ThanhLongJackieChanKimHeeSun-592644.mp3?st=CqMGye_ZKeYTF5BzRUTgyA&amp;e=1559860815&amp;download=true',
        'name' => 'Endless love'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui957/SaiNguoiSaiThoiDiem-ThanhHungIdol-5333777.mp3?st=QgZ1Pa8fGpM1IpNYSJ624A&amp;e=1559860852&amp;download=true',
        'name' => 'Sai người sai thời điểm'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui975/YeuEmDaiKhoAcousticLive-LouHoang-5838190.mp3?st=6HPOky1LNDPPG5Xvx8W_gQ&amp;e=1559860883&amp;download=true',
        'name' => 'Yêu Em Dại Khờ (Acoustic Live)'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui117/LiuXingYuMuaSaoBang-F4_t5p5.mp3?st=JoWxfes9p2ftNmAIE6AnBg&amp;e=1559860911&amp;download=true',
        'name' => 'Liu Xing Yu (Mưa Sao Băng)'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui946/YeuNhuNgayYeuCuoi-MaiTienDung-5085422.mp3?st=x67vBsnsMp6hLWnMWvKfxw&amp;e=1559860943&amp;download=true',
        'name' => 'Yêu Như Ngày Yêu Cuối'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui154/YeuLaiTuDau-KhacViet_354qr.mp3?st=edb4UcEyo038qgBuwSJveQ&amp;e=1559860975&amp;download=true',
        'name' => 'Yêu Lại Từ Đầu'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui966/SuytNuaThiChuyenDiCuaThanhXuanOST-Andiez-5524811.mp3?st=3e2e43gX076ZsPw7QhWtRA&amp;e=1559861009&amp;download=true',
        'name' => 'Suýt Nữa Thì (Chuyến Đi Của Thanh Xuân OST)'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/Sony_Audio52/ThanhXuan-DaLAB-5773854.mp3?st=DHVERmyhR2jA4UsaplfN-A&amp;e=1559861041&amp;download=true',
        'name' => 'Thanh Xuân'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui966/HoaRaEmLaNguoiThuBa-QuachTuHeUyTuWeiZai-5524343.mp3?st=XYSpmUroz7zmBTUkzbv20Q&amp;e=1559861074&amp;download=true',
        'name' => 'Hóa Ra Em Là Người Thứ Ba'
    ]
];

$videoData = [
    'https://www.dropbox.com/s/fou24unz73x54jh/hIleTWKlfZz9l7Z9yKCHpMtHE4qP4ginVOqRz6SH.mp4?dl=1',
];

$factory->define(Media::class, function (Faker $faker) use ($musicData, $videoData) {
    $type = $faker->randomElement([1, 2]);
    $music = [];
    $albumId = null;

    if ($type == 1) {
        $music = $musicData[array_rand($musicData)];
        $albumId = Album::all()->random()->id;
    } else {
        $video = $videoData[array_rand($videoData)];
    }

    return [
        'album_id' => $albumId,
        'region_id' => Region::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'url' => empty($music) ? $video : 'https://www.dropbox.com/s/rr1fgy0vt10mpk2/7OBIAdjXyXKgadqX6t3LZ254EumNqzWYGRw8j7R2.mpga?dl=1',
        'name' => empty($music) ? implode(' ', $faker->words(3)) : $faker->bothify($music['name'] . ' (#?)'),
        'type' => $type,
        'lyrics' => '',
        'artist_name' => User::all()->random()->name,
        'cover_image' => $faker->imageUrl(640, 300),
        'status' => 1,
        'views' => $faker->numberBetween(100, 10000),
        'lyrics_contributer_name' => User::all()->random()->name,
        'path_media' => '',
    ];
});

$factory->define(Role::class, function (Faker $faker) {
    return [];
});

$factory->define(Region::class, function (Faker $faker) {
    return [];
});

$factory->define(Kind::class, function (Faker $faker) {
    return [];
});

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'cover_image' => '/frontend/images/region_kind/rock_bg.jpg'
    ];
});

$factory->define(WeekyView::class, function (Faker $faker) {
    return [];
});

$factory->define(Like::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'status' => 1,
    ];
});

$factory->define(Follow::class, function (Faker $faker) {
    $userId = User::all()->random()->id;
    $followId = User::where('id', '!=', $userId)->where('role_id', config('setting.user.role.artist'))->get()->random()->id;

    return [
        'user_id' => $userId,
        'follow_id' => $followId,
    ];
});

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'commentable_id' => '',
        'commentable_type' => '',
        'content' => $faker->sentence,
        'status' => 1,
    ];
});
