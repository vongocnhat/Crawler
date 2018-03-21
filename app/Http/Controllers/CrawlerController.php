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
ini_set('max_execution_time', 86400);

class CrawlerController extends Controller
{
    private $LoadLimit = 1;
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
    private $hasError = false;
    public function index()
    {
        echo '<a style="background-color: #28a745; color:#fff; padding: 15px;" href="'.route("home").'">Home</a><br><br>';
        $time1 = date('H:i:s', time());
        echo 'Start: '.$time1.'</br>';
        // lấy dữ liệu từ database
        $keyWords = KeyWord::Where('Active', 1)->get();
        $websites = Website::where('Active', 1)->get();
        $VideoTagDB = VideoTag::first();
        if(is_null($VideoTagDB))
        {
            echo '<script>alert("VideoTag Không Được Để Trống");</script>';
            return;        
        }
        $this->videoTag = $VideoTagDB->name;
        foreach ($websites as $key => $website) {
            $this->domainName = $website->domainName;
            $this->menuTag = $website->menuTag;
            $this->numberPage = $website->numberPage;
            $this->limitOfOnePage = $website->limitOfOnePage;
            $this->stringFirstPage = $website->stringFirstPage;
            $this->stringLastPage = $website->stringLastPage;
            // */ lấy dữ liệu từ database
            // lấy danh mục tin tức
            $requests = function () {
                yield new GuzzleRequest('GET', $this->domainName);
            };
            $client = new GuzzleClient();
            $pool = new Pool($client, $requests(), [
                'concurrency' => $this->LoadLimit,
                'fulfilled' => function ($response, $index) use($website, $keyWords) {
                    $document = new Crawler((string)$response->getBody());
                    $nodes = $document->filter($this->menuTag);
                    for ($i=0; $i < $nodes->count(); $i++) { 
                        if($nodes->eq($i)->count() > 0)
                        {
                            $menuHref = $nodes->eq($i)->attr('href');
                            if(!$this->startWithHtml($menuHref))
                                $menuHref = $this->domainName.$menuHref;
                            // lấy danh mục tin tức
                            echo $menuHref.'</br>';
                            $this->GetNews($menuHref, $website, $keyWords);
                            // */lấy danh mục tin tức
                        }
                        else
                        {
                            echo '<span style="color:red">Sai menuTag Của Website: '.$this->domainName.'</span>';
                        }
                    }
                },
                'rejected' => function ($reason, $index) {
                    // this is delivered each failed request
                    echo '<span style="color:red">Không Thể Kết Nối Đến: '.$this->domainName.' Có Thể Do Sai Đường Dẫn</span><br>';
                    $this->hasError = true;
                },
            ]);
            // Initiate the transfers and create a promise
            $promise = $pool->promise();
            // Force the pool of requests to complete.
            $promise->wait();

            
        }
        $time2 = date('H:i:s', time());
        echo 'End: '.$time2.'</br>';
        $timestamp1 = strtotime($time1);
        $timestamp2 = strtotime($time2);
        echo 'Sum: '.($timestamp2 - $timestamp1).'<br>';
        //60s tải 1 lần
        $refreshTime = 15000;
        if($this->hasError)
        {
            //5s tải 1 lần
            $refreshTime = 5000;
            echo '<span style="color: red">Không Thể Tải 1 Số Tin Tức Tải Lại Sau: '.($refreshTime/1000).' Giây</span>';
        }
        else
        {
            echo '<span style="color: green">Đã Tải Thành Công Tải Lại Sau: '.($refreshTime/1000).' Giây</span>';
        }
        return view('admin.rss', compact('refreshTime'));
    }

    public function setSummaryBody($menuHref, $website) {
                $count = 0;
        $client = new GuzzleClient();
        $this->summaryBody = '';
        // lấy 1 cái để kiểm tra có đúng đường dẫn không
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
        // tiếp tục lấy những tin còn lại
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
        $listTitleInserted = [];
        $contents = Content::all();
        // $document = new Crawler($this->summaryBody);
        $this->setSummaryBody($menuHref, $website);
        $document = new Crawler($this->summaryBody); 
        echo $website->DetailWebsites()->where('active', 1)->count() == 0 ? '<span style="color: red">'.$website->domainName.' Chưa Có DetailWebsite</span><br>' : '';
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
                        $available = false;
                        foreach ($contents as $key => $content) {
                            if($title == $content->title)
                            {
                                // echo 'true'.$title.'|||||||||'.$item->title.$i.'</br>';
                                $available = true;
                                break;
                            }
                        }
                        if($available == false)
                        {
                            if(!$this->startWithHtml($href))
                                $href = $this->domainName.$titleNode->eq(0)->attr('href');
                            $matchChar = false;
                            foreach ($keyWords as $keyWord) {
                                if($this->matchChar($title, $keyWord->name))
                                // if(1 == 1)
                                {
                                    $matchChar = true;
                                    break;
                                }
                            }
                            $inserted = false;
                            foreach ($listTitleInserted as $key => $titleInserted) {
                                if($titleInserted == $title)
                                {
                                    $inserted = true;
                                    // break listLinkInserted
                                    break;
                                }
                            }
                            $checkPubDate = false;
                            if($detailWebsite->updateTimeTag != '')
                            {
                                $updateTimeNode = $item->filter($detailWebsite->updateTimeTag);
                                if($updateTimeNode->count() > 0)
                                {
                                    $updateTime = $updateTimeNode->text();
                                    $updateTime = str_replace('/', '-', $updateTime);
                                    //convert datetime
                                    $updateTime = date("Y-m-d H:i:s", strtotime($updateTime));
                                    $pubDay = date("Y-m-d", strtotime($updateTime));
                                    $now = date('Y-m-d');
                                    //không xác định được ngày đăng tin
                                    if($pubDay == $now)
                                    {
                                        $checkPubDate = true;
                                    }
                                    if($pubDay == '1970-01-01')
                                    {
                                        $checkPubDate = true;
                                        $updateTime = null;
                                    }

                                }
                            }else {
                                $checkPubDate = true;
                            }
                            if($matchChar == true && $inserted == false && $checkPubDate == true)
                            {
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
                                if($updateTime == '')
                                    $updateTime = null;
                                $content->pubDate = $updateTime;
                                $client = new GuzzleClient();
                                $request = $client->request('GET', $href, ['http_errors' => false]);
                                $document = new Crawler((string)$request->getBody());
                                $body = $document->filter($detailWebsite->Websites->bodyTag);
                                if($website->exceptTag != '')
                                    $body->filter($website->exceptTag)->each(function (Crawler $crawler) {
                                    foreach ($crawler as $node) {
                                        $node->parentNode->removeChild($node);
                                    }
                                });
                                // $sumBody = '';
                                // for ($j=0; $j < $body->count(); $j++) { 
                                //     $sumBody .= $body->eq($j)->outerHtml();
                                // }
                                // $body = new Crawler($sumBody);
                                
                                // có video là dùng iframe khi đó  $content->body = ''
                                $content->body = '';
                                if($body->count() > 0)
                                {
                                    if($this->videoTag != '')
                                        if($body->filter($this->videoTag)->count() == 0)
                                            $content->body = $body->outerHtml();
                                }
                                $content->save();
                                array_push($listTitleInserted, $title);
                            }
                        }
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
    private function matchChar($string, $keyWord) {
        $string = ' '.$string.' ';
        $string = $this->removeSymbol($string);
        $keyWord = $this->removeSymbol($keyWord);
        $index = stripos($string, $keyWord);
        if($index == true && gettype($index) == 'integer')
        {
            $indexBefore = $index-1;
            $indexAfter = $index+strlen($keyWord);
            $charBefore = substr($string, $indexBefore, 1);
            $charAfter = substr($string, $indexAfter, 1);
            // '*How area you?*' contain 'how are' = false
            // '*How are" you?*' contain 'how are' = true
            if(!(ctype_alpha($charBefore) || ctype_alpha($charAfter)))
                return true;
        }
        return false;
    }
    private function removeSymbol($string) {
        $charStrings = str_split($string);
        $string = '';
        $asc = -1;
        foreach ($charStrings as $value) {
            $asc = ord($value);
            if(!(($asc >= 33 && $asc <= 47) || ($asc >= 58 && $asc <= 64) || ($asc >= 91 && $asc <= 96) || ($asc >= 123 && $asc <= 126)))
                $string .= $value;
        }
        // thay thế nhiều dấu space thành 1 dấu
        $string = preg_replace('!\s+!', ' ', $string);
        return $string;
    }
}