@extends('admin.layouts.default')
@section('content')
<h3>Bảng VideoTag</h3>
{{-- nhận thông điệp từ controller --}}
<div>
  @if(Session::has('thongbao'))
    <span class="alert alert-success">{{ Session::get('thongbao') }}</span>
  @endif
</div>
{!! Form::model($videoTag, ['route' => ['videotag.update', 'id' => $videoTag->id], 'method' => 'put', 'class' => 'col-12']) !!}
  <div class="form-group">
    {{ Form::label(null, 'Name: ') }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
  </div>
  <div class="form-group"> 
    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
    {{ Form::button('Cancel', ['onclick' => 'history.go(-1)', 'class'=>'btn btn-danger']) }}
  </div>
{!! Form::close() !!}
@endsection