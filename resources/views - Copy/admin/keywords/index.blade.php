@extends('admin.layouts.default')
@section('title',"Kiem Tra")
@section('content')
      <div class="row">
  @if(Session::has('ketqua')) 
    <p class="alert alert-success">{{Session::get('ketqua')}}</p>
  @endif
</div>
      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header card-header-padding">
         
          <a class="nav-link" href="{{URL::route('keyword.create')}}">
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
                  <th>Name</th>
                  <th>Active</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Active</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($key as $data)
                <tr>
                  <td>{{$data->id}}</td>
                  <td>{{$data->name}}</td>
                  <td>{{$data->active ? 'Yes' : 'No' }}</td>
                  <td><a href="{{ URL::route('keyword.edit', ['keyword' => $data->id]) }}" class="btn btn-success">Edit</a></td>
                  <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['keyword.destroy', 'keyword' => $data->id]]) !!}
                      {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa KeyWord Có Name: $data->name , Id: $data->id ?')"]) }}
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





