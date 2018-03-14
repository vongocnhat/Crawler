<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\Website;
use App\DetailWebsite;
use App\KeyWord;
use App\Content;
use App\VideoTag;
ini_set('max_execution_time', 3600);

class CrawlerController extends Controller
{
    private $LoadLimit = 5;
    // Websites from database
    private $domainName = 'http://www.24h.com.vn';
    private $menuTag = '#zone_footer > ul > li';
    private $numberPage = 2;
    private $limitOfOnePage = 14;
    private $stringFirstPage = '?vpage=';
    private $stringLastPage = '';
    // */Websites from database
    // DetailWebsites form database
    private $containerTag = '.boxDoi-sub-Item-trangtrong';
    private $titleTag= '.news-title';
    private $summaryTag = '.news-sapo';
    private $updateTimeTag = '.update-time';

    // private $containerTag = '.baiviet-TopContent';
    // private $titleTag= '.news-title16-G';
    // private $summaryTag = '.news-sapo';
    // private $updateTimeTag = '.update-time';
    // */DetailWebsites form database
    // keywords table
    private $KeyWords;
    // */keywords table
    private $summaryBody = '';
    private $listNews = [];
    private $videoTag = '';
    public function index()
    {

        $time1 = date('H:i:s', time());
        echo 'Start: '.$time1.'</br>';
        // lấy dữ liệu từ database
        $keyWords = KeyWord::Where('Active', 1)->get();
        $websites = Website::where('Active', 1)->get();
        foreach (VideoTag::all() as $key => $item) {
            $this->videoTag = $item->name;
        }
        foreach ($websites as $key => $website) {
            $this->domainName = $website->domainName;
            $this->menuTag = $website->menuTag;
            $this->numberPage = $website->numberPage;
            $this->limitOfOnePage = $website->limitOfOnePage;
            $this->stringFirstPage = $website->stringFirstPage;
            $this->stringLastPage = $website->stringLastPage;
            // */ lấy dữ liệu từ database
            // lấy danh mục tin tức
            $client = new GuzzleClient();
            $crawler = $client->request('GET', $this->domainName);
            $document = new Crawler((string)$crawler->getBody());
            $nodes = $document->filter($this->menuTag);
            // for ($i=0; $i < $nodes->count(); $i++) { 
            for ($i=1; $i < 2; $i++) { 
                if($nodes->eq($i)->count() > 0)
                {
                    $menuHref = $nodes->eq($i)->attr('href');
                    if(!$this->startWithHtml($menuHref))
                        $menuHref = $this->domainName.$menuHref;
                    // lấy danh mục tin tức
                    // echo $menuHref.'</br>';
                    $this->GetNews($menuHref, $website, $keyWords);
                    // */lấy danh mục tin tức
                }
                else
                {
                    echo '<script>alert("Sai menuTag Của Website: '.$this->domainName.'");</script>';
                }
            }
        }
        $time2 = date('H:i:s', time());
        echo 'End: '.$time2.'</br>';
        $timestamp1 = strtotime($time1);
        $timestamp2 = strtotime($time2);
        echo 'Sum: '.($timestamp2 - $timestamp1);
    }

    public function getNews($menuHref, $website, $keyWords) {
        // biến để chứa node
        $titleNode;
        $hrefNode;
        $summaryNode;
        $updateTimeNode;
        // */biến để chứ tag
        // biến lấy để hiển thị ra view
        $title;
        $href;
        $summary;
        $updateTime;
        $document = new Crawler($this->summaryBody);
        $count = 0;
        $client = new GuzzleClient();
        $this->summaryBody = '';
        // lấy 1 cái để kiểm tra trước
        $document1 = $client->request('GET', $menuHref.$this->stringFirstPage.'1'.$this->stringLastPage, ['http_errors' => false]);
        $tempDocument = new Crawler((string)$document1->getBody());
        foreach ($website->DetailWebsites()->where('active', 1)->get() as $key => $detailWebsite) {
            $items = $tempDocument->filter($detailWebsite->containerTag);
            if($items->count() > 0)
                $count++;
        }
        $this->summaryBody .= $tempDocument->html();
        if($count == 0)
        {
            return;
        }
        // */biến lấy để hiển thị ra view
        // // Initiate each request but do not block danh sách đường dẫn
        if($this->numberPage > 1)
        {
            $promises = [];
            $requests = function () use ($menuHref) {
                for ($i = 1; $i < $this->numberPage; $i++) {
                    yield new GuzzleRequest('GET', $menuHref.$this->stringFirstPage.($i+1).$this->stringLastPage, ['http_errors' => false]);
                }
            };
            //reset $this->summaryBody;
            $pool = new Pool($client, $requests(), [
                'concurrency' => $this->LoadLimit,
                'fulfilled' => function ($response, $index) use ($website) {
                    // this is delivered each successful response
                    //get body fake :))))
                    $tempDocument = new Crawler((string)$response->getBody());
                    $this->summaryBody .= $tempDocument->html();
                },
                'rejected' => function ($reason, $index) {
                    // this is delivered each failed request
                    
                },
            ]);
            // Initiate the transfers and create a promise
            $promise = $pool->promise();
            // Force the pool of requests to complete.
            $promise->wait();
        }
        if($this->summaryBody == '')
            return;
        $document = new Crawler($this->summaryBody);
        foreach ($website->DetailWebsites()->where('active', 1)->get() as $key => $detailWebsite) {
            $items = $document->filter($detailWebsite->containerTag);
            for ($i=0; $i < $this->limitOfOnePage; $i++) { 
                $item = $items->eq($i);
                //remove tag not use
                // $item->filter('.news-sapo , .news-title')->each(function (Crawler $crawler) {
                //     foreach ($crawler as $node) {
                //         $node->parentNode->removeChild($node);
                //     }
                // });
                // */remove tag not use
                //require
                $title = '';
                $href = '';
                $summary = '';
                $updateTime = '';
                if($detailWebsite->titleTag != '')
                {
                    $titleNode = $item->filter($detailWebsite->titleTag);
                    if($titleNode->count() > 0)
                    {
                        $title = $titleNode->eq(0)->attr('title');
                        if($title == '')
                            $title = $titleNode->eq(0)->text();
                        $href = $titleNode->eq(0)->attr('href');
                        if(!$this->startWithHtml($href))
                            $href = $this->domainName.$titleNode->eq(0)->attr('href');
                        $content = new Content();
                        $content->domainName = $this->domainName;
                        $content->title = $title;
                        $content->link = $href;
                        if($detailWebsite->summaryTag != '')
                        {
                            $summaryNode = $item->filter($detailWebsite->summaryTag);
                            if($summaryNode->count() > 0)
                            {
                                $summary = $summaryNode->text();
                                $content->description = $summary;
                            }
                        }
                        if($detailWebsite->updateTimeTag != '')
                        {
                            $updateTimeNode = $item->filter($detailWebsite->updateTimeTag);
                            if($updateTimeNode->count() > 0)
                            {
                                $updateTime = $updateTimeNode->text();
                                //convert datetime
                                $updateTime = date("Y-m-d H:i:s", strtotime($updateTime));
                                // */convert datetime
                                $content->pubDate = $updateTime;
                            }
                        }
                        $client = new GuzzleClient();
                        $request = $client->request('GET', $href);
                        $document = new Crawler((string)$request->getBody());
                        $body = $document->filter($detailWebsite->Websites->bodyTag);
                        $content->body = '';
                        // có video là dùng iframe
                        if($body->count() > 0)
                        {
                            if($this->videoTag != '')
                                if($body->filter($this->videoTag)->count() == 0)
                                    $content->body = $body->outerHtml();
                        }
                        $content->save();
                    }
                }
            }
        }
    }
    private $time1;
    function start() {
        $this->time1 = date('H:i:s', time());
        echo 'Start: '.$this->time1.'</br>';
    }

    function end() {
        $time2 = date('H:i:s', time());
        echo 'End: '.$time2.'</br>';
        $timestamp1 = strtotime($this->time1);
        $timestamp2 = strtotime($time2);
        echo 'Sum: '.($timestamp2 - $timestamp1).'</br></br>';
    }

    function startWithHtml($href) {
        return substr( $href, 0, 4 ) == "http" ? true : false;
    }
    // tìm chính xác từ
    function matchChar($string, $keyWord) {
        $string = '*'.$string.'*';
        $index = stripos($string, $keyWord);
        // echo 'index: '.$index.'</br>';
        // echo 'type: '.gettype($index).'</br>';
        if($index == true && gettype($index) == 'integer')
        {
            $indexBefore = $index-1;
            $indexAfter = $index+strlen($keyWord);
            $charBefore = substr($string, $indexBefore, 1);
            $charAfter = substr($string, $indexAfter, 1);
            // echo 'string: '.$string.'</br>';
            // echo 'keyWord: '.$keyWord.'</br>';
            // echo 'before:'.$indexBefore.'| after:'.$indexAfter.'</br>';
            // echo 'before:'.$charBefore.'| after:'.$charAfter.'</br>';
            if(!(ctype_alpha($charBefore) || ctype_alpha($charAfter)))
            {
                // echo 'true'.'</br></br>';
                return true;
            }
        }
        // echo 'false'.'</br></br>';
        return false;
    }
}