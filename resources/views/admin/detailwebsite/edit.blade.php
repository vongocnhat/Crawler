@extends('admin.layouts.default')
@section('content')
<h3>Edit DetailWebsite</h3>
{{-- nhận thông điệp từ controller --}}
<div>
  @if(Session::has('thongbao'))
    <span class="alert alert-success">{{ Session::get('thongbao') }}</span>
  @endif
</div>
{!! Form::model($detailWebsite, ['route' => ['detailwebsite.update', 'id' => $detailWebsite->id], 'method' => 'put', 'class' => 'col-12']) !!}
  <div class="form-group">
    {{ Form::label(null, 'DomainName') }}
    {{ Form::select('domainName', $domainNames, null, ['class' => 'form-control', 'placeholder' => 'Chọn DomainName', 'required' => 'required']) }}
  </div>
  <div class="form-group">
    {{ Form::label(null, 'ContainerTag: ') }}
    {{ Form::text('containerTag', null, ['class' => 'form-control', 'required' => 'required']) }}
  </div>
  <div class="form-group">
    {{ Form::label(null, 'TitleTag') }}
    {{ Form::text('titleTag', null, ['class' => 'form-control', 'required' => 'required']) }}
  </div>
  <div class="form-group">
    {{ Form::label(null, 'SummaryTag') }}
    {{ Form::text('summaryTag', null, ['class' => 'form-control']) }}
  </div>
  <div class="form-group">
    {{ Form::label(null, 'UpdateTimeTag') }}
    {{ Form::text('updateTimeTag', null, ['class' => 'form-control']) }}
  </div>
  <div class="form-group" >
    {{form::label('Active','Active:')}}
    <div class="form-check form-check-inline">
      {!! Form::radio('active',1, null, ['class' =>'form-check-input', 'id' => 'yes']) !!}
      {{Form::label('yes','Yes',['class'=>'form-check-label'])}}
     </div>
    <div class="form-check form-check-inline">
      {!!Form::radio('active',0, null, ['class' =>'form-check-input', 'id' => 'no'])!!}
      {{Form::label('no','No',['class'=>'form-check-label'])}}  
    </div>
  </div>
  <div class="form-group"> 
    {{ Form::submit('Submit', ['class' => 'btn btn-success']) }}
    {{ Form::button('Cancel', ['onclick' => 'history.go(-1)', 'class'=>'btn btn-danger']) }}
  </div>
{!! Form::close() !!}
@endsection