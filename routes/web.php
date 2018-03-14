<?php
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\Content;
use App\RSS;
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
Route::get('rss', 'RSSController@index')->name('getRSS');

Route::get('crawler', 'CrawlerController@index');

Route::prefix('admin')->group(function () {
    Route::resource('website', 'WebsiteController');
	Route::resource('detailwebsite', 'DetailWebsiteController');
	Route::resource('keyword','KeyWordController');
	Route::resource('content','ContentController');
	Route::resource('rss','RSSAdminController');
	Route::resource('videotag','VideoTagController');
});
