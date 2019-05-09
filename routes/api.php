<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::get('/media/hot', 'MediaController@getHotMedia');
    Route::get('/media/new', 'MediaController@getNewMedia');
    Route::get('/media/slider', 'MediaController@getSliders');
    Route::get('/media/new-albums', 'MediaController@getNewAlbums');
    Route::get('/media/playlist', 'MediaController@getMediaForPlaylist');
    Route::get('/media/{id}/show', 'MediaController@show');
    Route::get('/media/{id}/comment', 'MediaController@getMediaComment');
    Route::get('/media/suggest', 'MediaController@getMediaSuggest');

    Route::get('/category/region/popular', 'CategoryController@getPopularRegions');
    Route::get('/category/top-view', 'CategoryController@getTopViewCategories');

    Route::get('/ranking/media', 'RankingController@getRankingMedia');
    Route::get('/ranking/artist', 'RankingController@getRankingArtist');
});
