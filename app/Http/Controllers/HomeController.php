<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\KeyWord;

class HomeController extends Controller
{
    public function index()
    {
        $refreshTime = 15;
        $refreshTime *= 1000;
        return view('home', compact('refreshTime'));
    }

    public function newsAjax()
    {
        $contents = Content::where('active', 1)->orderBy('pubDate', 'DESC')->get();
        $keyWords = KeyWord::Where('active', 1)->get();
        if($keyWords->count() > 0)
            foreach ($contents as $key => $content) {
                $keep = false;
                foreach ($keyWords as $keyWord) {
                    if($this->matchChar($content->title, $keyWord->name))
                    {
                        $keep = true;
                        break;
                    }
                }
                if($keep == false)
                {
                    $contents->forget($key);
                }
            }
        $toDayNewsCount = 0;
        foreach ($contents as $item) {
            $pubDate = date("Y-m-d", strtotime($item->pubDate));
            $toDate = date("Y-m-d");
            if($pubDate == $toDate)
                $toDayNewsCount++;
        }
        return view('newsAjax', compact('contents', 'toDayNewsCount'));
    }

    public function getNews(Request $request) {
    	$link = $request->input('href');
    	$content = Content::where('link', $link)->get();
    	foreach ($content as $key => $value) {
            
           
            if($value->body == '')
                // echo html_entity_decode('<iframe name="iframe1" id="iframe1" src="'.route('changeLink', ['id' => $value->id]).'" height="800px" width="100%" style="overflow: hidden;" frameborder="0" allowfullscreen >');
                echo html_entity_decode('<iframe name="iframe1" id="iframe1" src="'.$value->link.'" height="800px" width="100%" style="overflow: hidden;" frameborder="0" allowfullscreen >');
            else
            {
                echo html_entity_decode('<h3>'.$value->title.'</h3>');
                echo html_entity_decode('<b>'.$value->pubDate.'</b></br>');
                echo html_entity_decode('<h5 class="description">'.$value->description.'</h5></br>');
                echo html_entity_decode($value->body);
            }
            // echo    '
            // <script>
            //     var cssLink = document.createElement("link");
            //     cssLink.href = "http://localhost/Crawler/public/styles/nhat.css"; 
            //     cssLink.rel = "stylesheet"; 
            //     cssLink.type = "text/css"; 
            //     frames["iframe1"].document.body.appendChild(cssLink);
            // </script>';
    	}
    }

    public function changeLink($id) {
        $content = Content::findOrFail($id);
        $html = file_get_contents($content->link);
        // $html = str_replace('</head>','<link rel="stylesheet" href="http://localhost/Crawler/public/styles/nhat.css" /></head>', $html);
        echo $html;
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