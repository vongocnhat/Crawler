@extends('admin.layouts.default')
@section('content')
      <!-- Breadcrumbs-->
      
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header card-header-padding">
         
          <a class="nav-link" href="{{URL::route('website.create')}}">
             <button><i class="fas fa-globe"></i>
            <span class="nav-link-text"></span>
            
               Create
             </button>
          </a>
          
        <div class="card-body card-body-padding">

          <div class="table-responsive">
            {!! Form::open(['method'=>'DELETE', 'route'=>['website.destroy', 'website' => 0]])!!}
              {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa Tất Cả Nội Dung Được Checked Trong Trang Này ?')"]) }}
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th><input type="checkbox" class="thCbDelete"></th>
                  <th>Id</th>
                  <th>Domain Name</th>
                  <th>Menu Tag</th>
                  <th>Number Page</th>
                  <th>Limit Of One Page</th>
                  <th>Sting First Page</th>
                  <th>String Last Page</th>
                  <th>BodyTag</th>
                  <th>Except Tag</th>
                  <th>Active</th>
                  <th>Edit</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th><input type="checkbox" class="thCbDelete"></th>
                  <th>Id</th>
                  <th>Domain Name</th>
                  <th>Menu Tag</th>
                  <th>Number Page</th>
                  <th>Limit Of One Page</th>
                  <th>Sting First Page</th>
                  <th>String Last Page</th>
                  <th>BodyTag</th>
                  <th>Except Tag</th>
                  <th>Active</th>
                  <th>Edit</th>
          </td>
                </tr>
              </tfoot>
              <tbody>
                @foreach($website_data as $data)
                <tr>
                  <td><input type="checkbox" class="tdCbDelete" name="idCheckbox[]" value="{{$data->id}}"></td>
                  <td>{{ $data->id }}</td>
                  <td>{{ $data->domainName }}</td>
                  <td>{{ $data->menuTag }}</td>
                  <td>{{ $data->numberPage }}</td>
                  <td>{{ $data->limitOfOnePage }}</td>
                  <td>{{ $data->stringFirstPage }}</td>
                  <td>{{ $data->stringLastPage }}</td>
                  <td>{{ $data->bodyTag }}</td>
                  <td>{{ $data->exceptTag }}</td>
                  <td>
                    <label><input type="checkbox" class="tdCbActive" value="{{ $data->id }}" {{$data->active ? 'checked="checked' : '' }}"><span>{{ $data->active ? ' Yes' : ' No' }}</span></label>
                  </td>
                  <td>
                    <a href="{{ route('website.edit', ['website' => $data->id]) }}" class="btn btn-info">Edit</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {!! Form::close()!!}
          </div>
        </div>
@stop
@section('script')
  <script type="text/javascript">
    $('.tdCbActive').click(function() {
      var id = $(this).val();
      $.ajax({
        url: '{{ route('website.active') }}',
        data: {id: id}
      });
    });
  </script>
@stop