<?php

use App\Models\User;
use App\Models\Media;
use App\Models\Role;
use App\Models\Region;
use App\Models\Kind;
use App\Models\Album;
use App\Models\Like;
use App\Models\Follow;

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
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'avatar' => $faker->imageUrl(100, 100),
        'gender' => 3,
        'description' => '',
        'role_id' => $faker->randomElement([1, 2]),
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
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui946/DongThoai-MichaelWongQuangLuong-161624_hq.mp3?st=-VcR6k46GfZur5GNgqNYvQ&amp;e=1557152476&amp;download=true',
        'name' => 'Tong Hua'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui956/ThanThoai-ThanhLongJackieChanKimHeeSun-113987_hq.mp3?st=F8oAypasyDhPGWiRC0eZNQ&e=1557152510&download=true',
        'name' => 'Endless love'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui957/SaiNguoiSaiThoiDiem-ThanhHungIdol-5333777.mp3?st=W9yKIoeq5B32WjCMAT5QiA&amp;e=1557152533&amp;download=true',
        'name' => 'Sai người sai thời điểm'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui975/YeuEmDaiKhoAcousticLive-LouHoang-5838190_hq.mp3?st=8qPRNV5thrT51JyNQ-W6Ow&amp;e=1557150880&amp;download=true',
        'name' => 'Yêu Em Dại Khờ (Acoustic Live)'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui117/LiuXingYuMuaSaoBang-F4_t5p5.mp3?st=L3NqKr4IferSpdAw-6dEfQ&amp;e=1557150929&amp;download=true',
        'name' => 'Liu Xing Yu (Mưa Sao Băng)'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui946/YeuNhuNgayYeuCuoi-MaiTienDung-5085422.mp3?st=HsCQq7ZsvMt2fSLIhZkDUA&amp;e=1557152583&amp;download=true',
        'name' => 'Yêu Như Ngày Yêu Cuối'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui154/YeuLaiTuDau-KhacViet_354qr.mp3?st=Zz0Oh9tUqEE3ZghcYmgq6A&amp;e=1557152618&amp;download=true',
        'name' => 'Yêu Lại Từ Đầu'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui966/SuytNuaThiChuyenDiCuaThanhXuanOST-Andiez-5524811.mp3?st=PaeSmyNMCK5xqjcP34HzIw&amp;e=1557152657&amp;download=true',
        'name' => 'Suýt Nữa Thì (Chuyến Đi Của Thanh Xuân OST)'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/Sony_Audio52/ThanhXuan-DaLAB-5773854.mp3?st=F1xuNAkSLTYCvsHmsWMlag&amp;e=1557152682&amp;download=true',
        'name' => 'Thanh Xuân'
    ],
    [
        'url' => 'https://aredir.nixcdn.com/NhacCuaTui966/HoaRaEmLaNguoiThuBa-QuachTuHeUyTuWeiZai-5524343.mp3?st=ZQLU5w6VAuRnvaTmbfXCUw&amp;e=1557151523&amp;download=true',
        'name' => 'Hóa Ra Em Là Người Thứ Ba'
    ]
];

$factory->define(Media::class, function (Faker $faker) use ($musicData) {
    $type = $faker->randomElement([1, 2]);
    $music = [];
    $albumId = null;

    if ($type == 1) {
        $music = $musicData[array_rand($musicData)];
        $albumId = Album::all()->random()->id;
    }

    return [
        'album_id' => $albumId,
        'region_id' => Region::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'url' => empty($music) ? '' : $music['url'],
        'name' => empty($music) ? implode(' ', $faker->words(3)) : $faker->bothify($music['name'] . ' (#?)'),
        'type' => $type,
        'lyrics' => '',
        'artist_name' => User::all()->random()->name,
        'cover_image' => $faker->imageUrl(640, 300),
        'status' => 1,
        'views' => $faker->numberBetween(100, 10000),
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
