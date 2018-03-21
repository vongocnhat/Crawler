@extends('admin.layouts.default')
@section('content')
{{ Form::model($webupdate,array('route'=>array('website.update',$webupdate->id),'method'=>'put'))}}
  <div class="container">
  <h1 >Update </h1>
  <hr>
  <div class="form-group">
    {{ Form::label('domainName','DomainName')}}
    {{ Form::text('domainName',null, ['class'=>'form-control', 'required' => 'required']) }}
  </div>  
  <div class="form-group">
    {{ Form::label('menuTag','MenuTag ')}}
    {{ Form::text('menuTag',null,['class'=>'form-control', 'required' => 'required'])}}
  </div>
  <div class="form-group">
    {{form::label('numberPage','NumberPage')}}
    {{form::number('numberPage',null,['class'=>'form-control', 'required' => 'required'])}}
  </div>
  <div class="form-group">
    {{form::label('limitOfOnePage','LimitOfOnePage:')}}
    {{form::number('limitOfOnePage',null,['class'=>'form-control', 'required' => 'required'])}}
  </div>
  <div class="form-group">
    {{form::label('stringFirstPage','StringFirstPage:')}}
    {{form::text('stringFirstPage',null,['class'=>'form-control', 'required' => 'required'])}}
  </div>
  <div class="form-group">
    {{form::label('stringLastPage','StringLastPage:')}}
    {{form::text('stringLastPage',null,['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('bodyTag','BodyTag:')}}
    {{form::text('bodyTag',null,['class'=>'form-control', 'required' => 'required'])}}
  </div>
  <div class="form-group">
    {{form::label('exceptTag','exceptTag:')}}
    {{form::text('exceptTag',null,['class'=>'form-control'])}}
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


  </div>
      {!! Form::close() !!}

    </div>
    @stop