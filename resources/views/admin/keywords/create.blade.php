@extends('admin.layouts.default')
<!-- declase the ingredient of layout master -->
@section('Title','get persional list')
@section('content')
   
    <div class="container-fluid">
  <h1 >Create </h1><hr>
  <div class="row">
    @if(Session::has('ketqua')) 

        <p class="alert alert-success">{{Session::get('ketqua')}}</p>

    @endif
</div>

<div class="container">

{{ Form::open(array('route'=>'keyword.store','method'=>'post'))}}
<div class="form-group">
{{ Form::label('name','Name')}}
{{ Form::text('name','', ['class'=>'form-control']) }}
</div>  
<div class="form-group" >
  {{form::label('active','Active:')}}
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