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
       
        <a class="nav-link" href="{{URL::route('content.create')}}">
           <button>
          <span class="far fa-address-book"></span>
             Create
           </button>
        </a>
        
      <div class="card-body card-body-padding">

        <div class="table-responsive">

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Id</th>
                <th>DomainName</th>
                <th>Title</th>
                <th>PubDate</th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Id</th>
                <th>DomainName</th>
                <th>Title</th>
                <th>PubDate</th>
                <th>Active</th>
                <th>Update</th>
                <th>Delete</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach($content as $data)
              <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->domainName}}</td>
                <td>{{$data->title}}</td>
                <td>{{$data->pubDate}}</td>
                <td>{{$data->active ? 'Yes' : 'No'}}</td>
      
                <td><a href="{{ URL::route('content.edit', ['content' => $data->id]) }}" class="btn btn-success">Edit</a></td>
                <td>
                  {!! Form::open(['method' => 'DELETE', 'route' => ['content.destroy', 'content' => $data->id]]) !!}
                    {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa Content Có Title: $data->title , Id: $data->id ?')"]) }}
                  {!! Form::close() !!}
                </td>
              </tr>
        @endforeach
    </tbody>
</table>
</div>
</div>
</div>
</div>
@stop





