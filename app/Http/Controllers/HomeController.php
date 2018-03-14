<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use App\KeyWord;

class HomeController extends Controller
{
    public function index()
    {
        // $keyWords = KeyWord::where('active', 1)->get();
        // $keyWordQuerys = [];
        // foreach ($keyWords as $key => $item) {
        //     $keyWordQuerys[$key] = ['title', 'like', '%'.$item->name.'%'];
        // }
        // $contents = Content::query();
        // $contents = $contents->where('active', 1);
        // $contents = $contents->where([$keyWordQuerys[0]]);
        // for ($i = 1 ; $i < count($keyWordQuerys) ; $i++) {
        //     $contents = $contents->orwhere([$keyWordQuerys[$i]]);
        // }
        $contents = Content::where('active', 1)->orderBy('pubDate', 'DESC')->get();
        // $contents = Content::all();
        return view('home', compact('contents'));
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
}