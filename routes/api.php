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

Route::group(['namespace' => 'Api'], function () {
    Route::get('/media/search', 'MediaController@search');
    Route::get('/media/hot', 'MediaController@getHotMedia');
    Route::get('/media/new', 'MediaController@getNewMedia');
    Route::get('/media/slider', 'MediaController@getSliders');
    Route::get('/media/new-albums', 'MediaController@getNewAlbums');
    Route::get('/media/playlist', 'MediaController@getMediaForPlaylist');
    Route::get('/media/{id}/show', 'MediaController@show');
    Route::post('/media/{id}/up-view', 'MediaController@upViewMedia');
    Route::get('/media/{id}/comment', 'MediaController@getMediaComment');
    Route::get('/media/suggest', 'MediaController@getMediaSuggest');
    Route::get('/media/{id}/download', 'MediaController@download');

    Route::get('/category/region/popular', 'CategoryController@getPopularRegions');
    Route::get('/category/top-view', 'CategoryController@getTopViewCategories');
    Route::get('/category/topic/hot', 'CategoryController@getTopicHot');
    Route::get('/category/{type}/all', 'CategoryController@getAllCatagories');

    Route::get('/ranking/media', 'RankingController@getRankingMedia');
    Route::get('/ranking/artist', 'RankingController@getRankingArtist');
    Route::get('/ranking/week-ranking', 'RankingController@getWeekRankings');

    Route::get('profile/{id}', 'ProfileController@show');

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('auth', 'AuthController@user');
        Route::post('logout', 'AuthController@logout');
        Route::get('profile', 'ProfileController@index');

        Route::post('profile/{id}/follow', 'ProfileController@follow');
        Route::get('auth/followings', 'AuthController@getFollowings');

        Route::post('/media', 'MediaController@store');
        Route::post('/media/{id}/update', 'MediaController@update');
        Route::delete('/media/{id}/delete', 'MediaController@destroy');
        Route::post('/media/like', 'MediaController@like');
        Route::post('/media/comment', 'MediaController@comment');
        Route::post('/media/report', 'MediaController@report');
        Route::post('/media/{id}/add-favourite', 'MediaController@addFavouriteList');
        Route::post('/media/{id}/remove-favourite', 'MediaController@removeFavouriteList');
        Route::get('/media/favourite-list', 'MediaController@getFavouriteList');
    });

    Route::middleware('jwt.refresh')->get('/token/refresh', 'AuthController@refresh');
});
