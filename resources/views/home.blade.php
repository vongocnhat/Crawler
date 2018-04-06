<!DOCTYPE html>
<html>
<head>
	<title>Tiêu Đề :v</title>
	<base href="{{ asset("/") }}">
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="styles/dialog.css">
  <link rel="stylesheet" type="text/css" href="styles/nhat.css">
</head>
<body>
<img src="images/logo2.jpg" width="100%">
<a class="btn btn-success" style="margin: 15px 0 15px 15px;" href="{{ route('home') }}">Home</a>
<a class="btn btn-success" style="margin: 15px;" href="{{ route('website.index') }}">Trang Quản Lý Admin</a>
<br>
<div class="news-container col-12">
  <div class="col-md-4 col-sm-12">
    {{ Form::open(['route' => 'home', 'method' => 'get', 'class' => 'row']) }}
    <div class="input-group">
      {{ Form::search('searchStr', $searchStr, ['class' => 'form-control', 'placeholder'=>'Search for...']) }}
      <span class="input-group-btn">
        {{ Form::submit('Tìm', ['class' => 'btn btn-success']) }}
      </span>
    </div>
    {{ Form::close() }}
  </div>

  <table id="example" cellspacing="0" width="100%">
  <thead>
      <tr>
          <th>Hôm Nay Có {{ $toDayNewsCount }} Tin Mới</th>
      </tr>
  </thead>
  @foreach($contents as $content)
    <tr>
        <td style="padding-bottom: 15px">
          <h4 class="d-block" style="margin-bottom: 5px">
            <a class="btn-title" href="{!! $content->link !!}" title="{!! $content->title !!}">{!! $content->title !!}
            </a>
          </h4>
          <span class="d-block text-success">{!! $content->link !!}</span>
          <span class="d-block btn-image">{!! $content->description !!}</span>
          <span class="d-block">{!! $content->pubDate !!}</span>
        </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $contents->render('pagination::bootstrap-4') }}
</div>
<div class="box-dialog">
  <div class="box-news">
    <div class="box-dialog-header">
      <span class="text-white dialog-title">Tin Tức</span>
      <button class="btn-close btn btn-danger float-right">X</button>
    </div>
    <div class="box-news-content">
    </div>
  </div>
</div>
<div id="script"></div>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript">

{{-- // var refreshTime = {{ $refreshTime }}; --}}
// if(refreshTime <= 0)
//   refreshTime = 15000;
// function myLoop () {           //  create a loop function
//    setTimeout(function () { 
//     $.ajax({
{{-- //       url: '{{ route('news-container') }}', --}}
//       success: function(result) {
//         $(".news-container").html(result);
//       }
//     });
//     myLoop();
//   }, refreshTime);
// }
// myLoop();
</script>
<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="styles/function.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
  $(".box-news").click(function(e) {
    e.stopPropagation();
  });
  $(".news-container").on('click', '.box-news-content', function(e) {
    e.preventDefault();
  });
  // button title click, // button image click ajax nen lam nhu vay
  $(".news-container").on('click', '.btn-title, .btn-image > a', function(e) {
    e.preventDefault();
    var href = $(this).attr('href');
    //get news
    $.ajax({
      url: '{{ route('getNews') }}',
      data: {href: href},
      success: function(result) {
        $(".box-news-content").html(result);
    }});
    $(".box-dialog").show(500);
    setTimeout(function () { 
      $("body").css({'overflow': 'hidden', 'margin-right': getScrollbarWidth()});
    }, 500);
    
    $(".box-dialog").scrollTop(0);
  });
  // button close click and dialog background black click
  $(".btn-close, .box-dialog").click(function() {
    $(".box-dialog" ).hide(500);
    $("body").css({'overflow': 'auto', 'margin-right': 0});
    $(".box-news-content").html('');
  });

  //esc close
  $('body').keyup(function(e){
    if(e.keyCode == 27){
        $(".btn-close").click();
    }
  });
  //load news
});

</script>
</body>
</html>