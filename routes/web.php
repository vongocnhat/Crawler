<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
// ajax
Route::get('news', 'HomeController@getNews')->name('getNews');
Route::get('changeLink/{id}', 'HomeController@changeLink')->name('changeLink');

Route::prefix('getnews')->group(function () {
	Route::get('rss', 'RSSController@index')->name('getRSS');
	Route::get('crawler', 'CrawlerController@index')->name('getCrawler');
});

Route::prefix('admin')->group(function () {
	Route::get('website/active', 'WebsiteController@active')->name('website.active');
    Route::resource('website', 'WebsiteController');

    Route::get('detailwebsite/active', 'DetailWebsiteController@active')->name('detailwebsite.active');
	Route::resource('detailwebsite', 'DetailWebsiteController');

	Route::get('keyword/active', 'KeyWordController@active')->name('keyword.active');
	Route::resource('keyword','KeyWordController');

	Route::get('content/active', 'ContentController@active')->name('content.active');
	Route::resource('content','ContentController');

	Route::get('rss/active', 'RSSAdminController@active')->name('rss.active');
	Route::resource('rss','RSSAdminController');

	Route::resource('videotag','VideoTagController');
});
