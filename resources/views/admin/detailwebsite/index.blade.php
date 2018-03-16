@extends('admin.layouts.default')
@section('content')
      <div class="card mb-3">
        <div class="card-header card-header-padding">
        <a href="{{ URL::route('detailwebsite.create') }}" class="btn btn-success">Create</a>
        <div class="card-body card-body-padding">
          <div class="table-responsive">
            {!! Form::open(['method' => 'DELETE', 'route' => ['detailwebsite.destroy', 'detailwebsite' => 0]]) !!}
              {{ Form::submit('Delete', ['class' => 'btn btn-danger btnDelete', 'onclick' => "return confirm('Xóa Tất Cả Nội Dung Được Checked Trong Trang Này ?')"]) }}
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th><input type="checkbox" class="thCbDelete"></th>
                    <th>Id</th>
                    <th>DomainName</th>
                    <th>ContainerTag</th>
                    <th>TitleTag</th>
                    <th>SummaryTag</th>
                    <th>UpdateTimeTag</th>
                    <th>Active</th>
                    <th>Edit</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th><input type="checkbox" class="thCbDelete"></th>
                    <th>Id</th>
                    <th>DomainName</th>
                    <th>ContainerTag</th>
                    <th>TitleTag</th>
                    <th>SummaryTag</th>
                    <th>UpdateTimeTag</th>
                    <th>Active</th>
                    <th>Edit</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach($detailWebsites as $data)
                  <tr>
                    <td><input type="checkbox" class="tdCbDelete" name="idCheckbox[]" value="{{$data->id}}"></td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->domainName }}</td>
                    <td>{{ $data->containerTag }}</td>
                    <td>{{ $data->titleTag }}</td>
                    <td>{{ $data->summaryTag }}</td>
                    <td>{{ $data->updateTimeTag }}</td>
                    <td>{{ $data->active ? 'Yes' : 'No' }}</td>
  						      <td><a href="{{ URL::route('detailwebsite.edit', ['detailwebsite' => $data->id]) }}" class="btn btn-success">Edit</a></td>
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