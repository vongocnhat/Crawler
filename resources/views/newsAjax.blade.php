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
<script type="text/javascript">
  $( document ).one('ajaxComplete', function() {
  $('#example').dataTable( {
    "order": [],
    "columnDefs": [ {
    "targets"  : 0,
    "orderable": false,
    }],
    "lengthMenu": [[10, 50, 100, 500, -1], [10, 50, 100, 500, "All"]]
  });
});
</script>