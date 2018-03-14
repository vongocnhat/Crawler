@extends('admin.layouts.default')
<!-- declase the ingredient of layout master -->
@section('Title','get persional list')
@section('content')
    {{ Form::open(array('route'=>'rss.store','method'=>'post'))}}
    <div class="container-fluid">
  <h1 >Create </h1><hr>
  <div class="row">
    @if(Session::has('ketqua')) 
        <p class="alert alert-success">{{Session::get('ketqua')}}</p>
    @endif
</div>
 
  <div class="form-group">
    {{ Form::label('domainName','domainName')}}
    {{ Form::text('domainName',null, ['class'=>'form-control']) }}
  </div>  
  <div class="form-group">
    {{ Form::label('menuTag','menuTag ')}}
    {{ Form::text('menuTag',null,['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('bodyTag','bodyTag')}}
    {{form::text('bodyTag',null,['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('exceptTag','exceptTag:')}}
    {{form::text('exceptTag',null,['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('ignoreRSS','ignoreRSS:')}}
    {{form::textarea('ignoreRSS',null,['class'=>'form-control', 'rows' => '4'])}}
  </div>
  <div class="form-group" >
    {{form::label('Active','Active:')}}
    <div class="form-check form-check-inline">
      {!! Form::radio('active',1, true, ['class' =>'form-check-input', 'id' => 'yes']) !!}
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

  
@stop
    <!-- Bootstrap core JavaScript-->
