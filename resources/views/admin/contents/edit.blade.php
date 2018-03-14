@extends('admin.layouts.default')
<!-- declase the ingredient of layout master -->
@section('Title','get persional list')
@section('content')
 {{ Form::model($edit,array('route'=>array('content.update',$edit->id),'method'=>'put'))}}
  <div class="container">
  <h1 >Edit </h1>
  <hr>
  <div class="form-group">
    {{ Form::label('domainName','domainName') }}
    {{ Form::select('domainName', $rsss, null, ['class' => 'form-control', 'placeholder' => 'Chọn DomainName']) }}
  </div>  
  <div class="form-group">
    {{ Form::label('title','title ')}}
    {{ Form::text('title',$edit->title,['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('link','link')}}
    {{form::text('link',$edit->link,['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('description','description:')}}
    {{form::textarea('description',$edit->description,['class'=>'form-control', 'rows' => 5])}}
  </div>
  <div class="form-group">
    {{form::label('body','body:')}}
    {{form::textarea('body',$edit->body,['class'=>'form-control', 'rows' => 10])}}
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
    {{form::submit('Send to as admin',['class'=>'btn btn-primary'])}}
  </div>
      {!! Form::close() !!}
    @stop