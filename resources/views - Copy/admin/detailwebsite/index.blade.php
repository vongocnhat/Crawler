@extends('admin.layouts.default')
@section('content')
      <div class="card mb-3">
        <div class="card-header card-header-padding">
        <a href="{{ URL::route('detailwebsite.create') }}" class="btn btn-success">Create</a>
        <div class="card-body card-body-padding">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>DomainName</th>
                  <th>ContainerTag</th>
                  <th>TitleTag</th>
                  <th>SummaryTag</th>
                  <th>UpdateTimeTag</th>
                  <th>Active</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Id</th>
                  <th>DomainName</th>
                  <th>ContainerTag</th>
                  <th>TitleTag</th>
                  <th>SummaryTag</th>
                  <th>UpdateTimeTag</th>
                  <th>Active</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($detailWebsites as $item)
                <tr>
                  <td>{{ $item->id }}</td>
                  <td>{{ $item->domainName }}</td>
                  <td>{{ $item->containerTag }}</td>
                  <td>{{ $item->titleTag }}</td>
                  <td>{{ $item->summaryTag }}</td>
                  <td>{{ $item->updateTimeTag }}</td>
                  <td>{{ $item->active ? 'Yes' : 'No' }}</td>
						      <td><a href="{{ URL::route('detailwebsite.edit', ['detailwebsite' => $item->id]) }}" class="btn btn-success">Edit</a></td>
						      <td>
						        {!! Form::open(['method' => 'DELETE', 'route' => ['detailwebsite.destroy', 'detailwebsite' => $item->id]]) !!}
						          {{ Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => "return confirm('Xóa Detail Website Có DomainName: $item->domainName , Id: $item->id ?')"]) }}
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