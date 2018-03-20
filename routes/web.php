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
Route::get('newsAjax', 'HomeController@newsAjax')->name('newsAjax');
// ajax
Route::get('news', 'HomeController@getNews')->name('getNews');
Route::get('changeLink/{id}', 'HomeController@changeLink')->name('changeLink');

Route::prefix('getnews')->group(function () {
	Route::get('rss', 'RSSController@index')->name('getRSS');
	Route::get('crawler', 'CrawlerController@index')->name('getCrawler');
});


Route::prefix('admin')->group(function () {
    Route::resource('website', 'WebsiteController');
	Route::resource('detailwebsite', 'DetailWebsiteController');
	Route::resource('keyword','KeyWordController');
	Route::resource('content','ContentController');
	Route::resource('rss','RSSAdminController');
	Route::resource('videotag','VideoTagController');

});
