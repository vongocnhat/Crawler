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

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Domain Name</th>
                  <th>Menu Tag</th>
                  <th>Number Page</th>
                  <th>Limit Of One Page</th>
                  <th>Sting First Page</th>
                  <th>String Last Page</th>
                  <th>BodyTag</th>
                  <th>Active</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Domain Name</th>
                  <th>Menu Tag</th>
                  <th>Number Page</th>
                  <th>Limit Of One Page</th>
                  <th>Sting First Page</th>
                  <th>String Last Page</th>
                  <th>BodyTag</th>
                  <th>Active</th>
                  <th>Edit</th>
                  <th>Delete</th>
          </td>
                </tr>
              </tfoot>
              <tbody>
                @foreach($website_data as $data)
                <tr>
                  <td>{{ $data->id }}</td>
                  <td>{{ $data->domainName }}</td>
                  <td>{{ $data->menuTag }}</td>
                  <td>{{ $data->numberPage }}</td>
                  <td>{{ $data->limitOfOnePage }}</td>
                  <td>{{ $data->stringFirstPage }}</td>
                  <td>{{ $data->stringLastPage }}</td>
                  <td>{{ $data->bodyTag }}</td>
                  <td>{{ $data->active ? 'Yes' : 'No' }}</td>
                  <td>
                    <a href="{{ route('website.edit', ['website' => $data->id]) }}" class="btn btn-info">Edit</a>
                  </td>        
                  <td>
                    {!! Form::open(['method'=>'DELETE', 'route'=>['website.destroy', 'website' => $data->id]])!!}
                      {{ Form::submit('DELETE', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa Website Có Domain Name: $data->domainName , Id: $data->id ?')"]) }}
                    {!! Form::close()!!}
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
@stop