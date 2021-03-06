<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use DOMDocument;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Promise;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use App\Content;
use App\RSS;
use App\VideoTag;
use App\KeyWord;
ini_set('max_execution_time', 86400);
class RSSController extends Controller
{
    private $LoadLimit = 1;
    private $summaryBody;
    private $videoTag = '';
    private $hasError = false;
    public function index()
    {
        echo '<a style="background-color: #28a745; color:#fff; padding: 15px;" href="'.route("home").'">Home</a><br><br>';
        $keyWords = KeyWord::where('active', 1)->get();
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
                'fulfilled' => function ($response, $index) use ($links, $RSS, $keyWords) {
                    // this is delivered each successful response
                    $document = new Crawler((string)$response->getBody());
                    $nodes = $document->filter($RSS->menuTag);
                    for ($i=0; $i < $nodes->count(); $i++) { 
                        # code...
                        $link = $nodes->eq($i)->attr('href');
                        if(!$this->startWithHtml($link))
                            $link = $this->getHostName($RSS->domainName).$link;
                        $checkIgnoreRSS = false;
                        foreach (explode(',', $RSS->ignoreRSS) as $key => $ignoreRSSValue) {
                            if(trim($ignoreRSSValue) == $link)
                            {
                                $checkIgnoreRSS = true;
                                break;
                            }
                        }
                        if($checkIgnoreRSS == false)
                            array_push($links, $link);
                    }
                    $this->setSummaryBody($links);
                    foreach ($links as $key => $link) {
                        echo ($key+1).': '.$link.'</br>';
                    }
                    unset($links);
                    $links = [];
                    $this->getNewsRSS($RSS, $keyWords);
                },
                'rejected' => function ($reason, $index) use ($RSS) {
                    // this is delivered each failed request
                    echo '<span style="color:red">Không Thể Kết Nối Đến: '.$RSS->domainName.' Có Thể Do Sai Đường Dẫn</span><br>';
                    $this->hasError = true;
                },
            ]);
            // Initiate the transfers and create a promise
            $promise = $pool->promise();
            // Force the pool of requests to complete.
            $promise->wait();
        }
        //60s táº£i 1 láº§n
        $refreshTime = 15000;
        if($this->hasError)
        {
            //5s táº£i 1 láº§n
            $refreshTime = 5000;
            echo '<span style="color: red">Không Thể Tải 1 Số Tin Tức Tải Lại Sau: '.($refreshTime/1000).' Giây</span>';
        }
        else
        {
            echo '<span style="color: green">Tải Tin Thành Công Tải Lại Sau: '.($refreshTime/1000).' Giây</span>';
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
                $str = str_replace('<link>', '<linkHref>', $response->getBody());
                $str = str_replace('</link>', '</linkHref>', $str);
                $str = str_replace('><![CDATA[', '>', $str);
                $str = str_replace(']]></', '</', $str);
                
                $tempDocument = new Crawler($str);
                // echo $tempDocument->html();
                if($tempDocument->count() == 0)
                {
                    $str = str_replace('<link>', '<linkHref>', $response->getBody());
                    $str = str_replace('</link>', '</linkHref>', $str);
                    $tempDocument = new Crawler($str);
                }
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

    private function getNewsRSS($RSS, $keyWords) {
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
        for ($i=0; $i < $items->count(); $i++) { 
            $title = '';
            $link = '';
            $description = '';
            $pubDate = '';
            $item = $items->eq($i);
            $title = $item->filter('title');
            $link = $item->filter('linkHref');
            if($title->count() > 0)
            {
                $title = $title->html();
            }
            else
                $title = '';
            if($link->count() > 0)
            {
                $link = $link->html();
            }
            else
                if($link->count() == 0 && $item->filter('guid')->count() > 0)
                    $link = $item->filter('guid')->html();
                else
                    $link = '';
            $description = $item->filter('description');
            if($description->count() > 0)
                $description = $description->html();
            else
                $description = '';
            $pubDate = $item->filter('pubDate');
            if($pubDate->count() > 0)
                $pubDate = $pubDate->html();
            else
                $pubDate = '';
            // add rss to database
            $available = false;
            foreach ($contents as $key => $item) {
                if($title == $item->title)
                {
                    // echo 'true'.$title.'|||||||||'.$item->title.$i.'</br>';
                    $available = true;
                    break;
                }
            }

            if($available == false)
            {
                $matchChar = false;
                foreach ($keyWords as $keyWord) {
                    if($this->matchChar($title, $keyWord->name))
                    // if(1 == 1)
                    {
                        //break keyWords;
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
                $pubDate = str_replace("/", '-', $pubDate); 
                $pubDay = date("Y-m-d", strtotime($pubDate));
                $now = date('Y-m-d');
                if($matchChar == true && $inserted == false && ($pubDay == $now || $pubDay == '1970-01-01'))
                {
                    $client = new GuzzleClient();
                    $request = $client->request('GET', $link, ['http_errors' => false]);
                    $content = new Content();
                    $content->domainName = $domainName;
                    $content->title = html_entity_decode($title);
                    $content->link = html_entity_decode($link);
                    // html_entity_decode to show "" '' / () or {!!!!}
                    $content->description = html_entity_decode($description);
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