@extends('admin.layouts.default')
@section('content')
	<div id="div1">
		{!! $document !!}
	</div>
@stop
@section('scripts')
<script type="text/javascript">
	// $('#iframe1').ready(function (event) {
		// iframeDoc.open();
	 //    iframeDoc.write('iframe here');
	 //    iframeDoc.write('\<script>alert("hello from iframe!");\<\/script>');
	 //    // iframeDoc.write('\<script>parent.hello();\<\/script>');
	 //    iframeDoc.close();
	 // console.log($(this).find('video').html());
	// }
	// $.ajax({
	//  	url: "https://www.google.com",
	//  	success: function(result){
 //        	$("#div1").html(result);
 //    	}
	// });
</script>
@stop