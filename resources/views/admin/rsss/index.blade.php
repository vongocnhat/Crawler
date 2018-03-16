@extends('admin.layouts.default')
@section('title',"Kiem Tra")
@section('content')
      <!-- Breadcrumbs-->
      <div class="row">
  @if(Session::has('ketqua')) 
    <p class="alert alert-success">{{Session::get('ketqua')}}</p>
  @endif
</div>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header card-header-padding">
         
          <a class="nav-link" href="{{URL::route('rss.create')}}">
             <button>
            <span class="far fa-address-book"></span>
               Create
             </button>
          </a>
          
        <div class="card-body card-body-padding">

          <div class="table-responsive">
            {!! Form::open(['method' => 'DELETE', 'route' => ['rss.destroy', 'rss' => 0]]) !!}
              {{ Form::submit('Delete', ['class' => 'btn btn-danger btnDelete', 'onclick' => "return confirm('Xóa Tất Cả Nội Dung Được Checked Trong Trang Này ?')"]) }}
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th><input type="checkbox" class="thCbDelete"></th>
                    <th>Id</th>
                    <th>domain Name</th>
                    <th>menu Tag</th>
                    <th>body Tag</th>
                    <th>except Tag</th>
                    <th>active</th>
                    <th>Update</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th><input type="checkbox" class="thCbDelete"></th>
                    <th>Id</th>
                    <th>domain Name</th>
                    <th>menu Tag</th>
                    <th>body Tag</th>
                    <th>except Tag</th>
                    <th>active</th>
                    <th>Update</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($rss as $data)
                  <tr>
                    <td><input type="checkbox" class="tdCbDelete" name="idCheckbox[]" value="{{$data->id}}"></td>
                    <td>{{$data->id}}</td>
                    <td>{{$data->domainName}}</td>
                    <td>{{$data->menuTag}}</td>
                    <td>{{$data->bodyTag}}</td>
                    <td>{{$data->exceptTag}}</td>
                    <td>{{$data->active ? 'Yes' : 'No' }}</td>
                    <td><a href="{{ URL::route('rss.edit', ['rss' => $data->id]) }}" class="btn btn-success">Edit</a></td>
                  </tr>
            @endforeach
        </tbody>
    </table>
    {!! Form::close() !!}
</div>
</div>
</div>
</div>
@stop





