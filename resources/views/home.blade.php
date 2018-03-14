<!DOCTYPE html>
<html>
<head>
	<title>Tiêu Đề :v</title>
	<base href="{{ asset("/") }}">
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="vendor/datatables/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="styles/dialog.css">
</head>
<body>
<a class="btn btn-success" style="margin: 15px;" href="{{ route('website.index') }}">Trang Quản Lý Admin</a>
<table id="example" cellspacing="0" width="100%">
  <thead>
      <tr>
          <th>Sắp Xếp</th>
      </tr>
  </thead>
  @foreach($contents as $content)
    <tr>
        <td style="padding-bottom: 15px">
          <h4 class="d-block" style="margin-bottom: 5px">
            <a class="btn-title" href="{!! $content->link !!}" title="{!! html_entity_decode($content->title) !!}">{!! html_entity_decode($content->title) !!}
            </a>
          </h4>
          <span class="d-block text-success">{{ $content->link }}</span>
          <span class="d-block btn-image">{!! html_entity_decode($content->description) !!}</span>
          <span class="d-block">{{ $content->pubDate }}</span>
        </td>
    </tr>
  @endforeach
  </tbody>
</table>
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
<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="vendor/datatables/jquery.dataTables.js"></script>
<script type="text/javascript" src="vendor/datatables/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="styles/function.js"></script>
<script src=”https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.js” 
type=”text/javascript”></script>
<script type="text/javascript">
$(document).ready(function() {
  $('#example').dataTable( {
  "order": [],
    "columnDefs": [ {
      "targets"  : 0,
      "orderable": false,
    }]
} );
});
$(".box-news").click(function(e) {
  e.stopPropagation();
});
// button title click, // button image click
$(".btn-title, .btn-image > a").click(function(e) {
  e.preventDefault();
  var href = $(this).attr('href');
  //get news
  $.ajax({
    url: '{{ route('getNews') }}',
    data: {href: href},
    success: function(result) {
      $(".box-news-content").html(result);
      // $('.box-news-content').find('script').each(function(i) {
      //   // $('#script').append($(this)[0].outerHTML);
      //   console.log($(this)[0].outerHTML);
      // });
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
</script>
</body>
</html>