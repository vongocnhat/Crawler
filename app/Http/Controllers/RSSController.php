<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use DOMDocument;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\Content;
use App\RSS;
use App\VideoTag;
use App\KeyWord;
ini_set('max_execution_time', 3600);
class RSSController extends Controller
{
    private $LoadLimit = 1;
    private $summaryBody;
    private $videoTag = '';
    private $hasError = false;
    public function index()
    {
        echo '<a style="background-color: #28a745; color:#fff; padding: 15px;" href="'.route("home").'">Home</a><br><br>';
        $RSSs = RSS::where('active', 1)->get();
        $links = [];
        $VideoTagDB = VideoTag::first();
        if(is_null($VideoTagDB))
        {
            echo '<script>alert("VideoTag Không Được Để Trống");</script>';
            return;        
        }
        $this->videoTag = $VideoTagDB->name;
        foreach ($RSSs as $RSS) {
            // $RSS->domainName
            // $RSS->menuTag
            // $RSS->exceptTag
            $requests = function () use ($RSS) {
                yield new GuzzleRequest('GET', $RSS->domainName);
            };
            //reset $summaryBody;
            $this->summaryBody = '';
            $client = new GuzzleClient();
            $pool = new Pool($client, $requests(), [
                'concurrency' => $this->LoadLimit,
                'fulfilled' => function ($response, $index) use ($links, $RSS) {
                    // this is delivered each successful response
                    $document = new Crawler((string)$response->getBody());
                    $nodes = $document->filter($RSS->menuTag);
                    $startI = 0;
                    if($RSS->ignoreHomePage && $nodes->count() > 1)
                        $startI = 1;
                    for ($i=0; $i < $nodes->count() - $startI; $i++) { 
                        # code...
                        $link = $nodes->eq($i+$startI)->attr('href');
                        if(!$this->startWithHtml($link))
                            $link = $this->getHostName($RSS->domainName).$link;
                        $links[$i] = $link;
                        // echo $links[$i].'</br>';
                    }
                    $this->setSummaryBody($links);
                    unset($links);
                    $links = [];
                    $this->getNewsRSS($RSS);
                },
                'rejected' => function ($reason, $index) {
                    // this is delivered each failed request
                    echo '<span style="color:red">Rơi Mạng Hoặc Sai Đường Dẫn RSS</span><br>';
                    echo $reason;
                    // $this->hasError = true;
                },
            ]);
            // Initiate the transfers and create a promise
            $promise = $pool->promise();
            // Force the pool of requests to complete.
            $promise->wait();
        }
        //60s tải 1 lần
        $refreshTime = 15000;
        if($this->hasError)
        {
            //5s tải 1 lần
            $refreshTime = 5000;
            echo '<span style="color: red">Không Thể Tải 1 Số Tin Tải Lại Sau: '.($refreshTime/1000).' giây</span>';
        }
        else
        {
            echo '<span style="color: green">Đã Tải Thành Công Các Trang Tải Lại Sau: '.($refreshTime/1000).' giây</span>';
        }
        return view('admin.rss', compact('refreshTime'));
    }

    private function setSummaryBody($links) {
        $promises = [];
        $requests = function () use ($links) {
            for ($i=0; $i < count($links); $i++) { 
                yield new GuzzleRequest('GET', $links[$i]);
            }
        };
        //reset $summaryBody;
        $this->summaryBody = '';
        $client = new GuzzleClient();
        $pool = new Pool($client, $requests(), [
            'concurrency' => $this->LoadLimit,
            'fulfilled' => function ($response, $index) {
                // this is delivered each successful response
                $tempDocument = new Crawler((string)$response->getBody());
                if($tempDocument->count() > 0)
                {
                    $this->summaryBody .= $tempDocument->html();
                }
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
                $this->hasError = true;
            },
        ]);
        // Initiate the transfers and create a promise
        $promise = $pool->promise();
        // Force the pool of requests to complete.
        $promise->wait();
    }

    private function getNewsRSS($RSS) {
        // table contents
        $domainName = $RSS->domainName;
        $listTitleInserted = [];
        $inserted = false;
        $title;
        $link;
        $description;
        $pubDate;
        $document = new Crawler($this->summaryBody);
        $items = $document->filter('item');
        // get table contents
        $contents = Content::all();
        // get table contents
        $keyWords = KeyWord::all();
        for ($i=0; $i < $items->count(); $i++) { 
            $title = '';
            $link = '';
            $description = '';
            $pubDate = '';
            $item = $items->eq($i);
            $title = $item->filter('title');
            $link = $item->filter('link');
            if($title->count() > 0)
                $title = $title->html();
            if($link->count() > 0)
            {
                $link = $link->html();
            }
            if($link == '' && $item->filter('guid')->count() > 0)
                $link = $item->filter('guid')->html();
            $description = $item->filter('description');
            if($description->count() > 0)
                $description = $description->html();
            $pubDate = $item->filter('pubDate');
            if($pubDate->count() > 0)
                $pubDate = $pubDate->html();
            // add rss to database
            $available = false;
            foreach ($contents as $key => $item) {
                if($link == $item->link)
                {
                    // echo 'true'.$title.'|||||||||'.$item->title.$i.'</br>';
                    $available = true;
                    break;
                }
            }
            if($available == false)
            {
                foreach ($keyWords as $keyWord) {
                    if($this->matchChar($title, $keyWord->name))
                    {
                        $inserted = false;
                        foreach ($listTitleInserted as $key => $titleInserted) {
                            if($titleInserted == $title)
                            {
                                $inserted = true;
                                // break listLinkInserted
                                break;
                            }
                        }
                        if($inserted == false)
                        {
                            $client = new GuzzleClient();
                            $request = $client->request('GET', $link);
                            $content = new Content();
                            $content->domainName = $domainName;
                            $content->title = $title;
                            $content->link = $link;
                            $content->description = $description;
                            //convert datetime
                            $pubDate = date("Y-m-d H:i:s", strtotime($pubDate));
                            // */convert datetime
                            $content->pubDate = $pubDate;
                            $document = new Crawler((string)$request->getBody());
                            $body = $document->filter($RSS->bodyTag);
                            if($RSS->exceptTag != '')
                                $body->filter($RSS->exceptTag)->each(function (Crawler $crawler) {
                                    foreach ($crawler as $node) {
                                        $node->parentNode->removeChild($node);
                                    }
                                });
                            $content->body = '';
                            // có video là dùng iframe
                            if($body->count() > 0)
                            {
                                if($this->videoTag != '')
                                    if($body->filter($this->videoTag)->count() == 0)
                                        try {
                                            $content->body = $body->outerHtml();
                                        } catch (Exception $e) {
                                            $content->body = '';
                                        }
                            }
                            // */add rss to database
                            $content->save();
                            array_push($listTitleInserted, $title);
                        }
                        //break keyWords;
                        break;
                    }
                }
            }      
        }
    }

    private function getContentBody($link) {

    }

    private function outerHTML($e) {
         $doc = new \DOMDocument();
         $doc->appendChild($doc->importNode($e, true));
         return $doc->saveHTML();
    }

    private function startWithHtml($href) {
        return substr( $href, 0, 4 ) == "http" ? true : false;
    }

    private function getHostName($domainName) {
        return parse_url($domainName, PHP_URL_SCHEME).'://'.parse_url($domainName, PHP_URL_HOST);
    }

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