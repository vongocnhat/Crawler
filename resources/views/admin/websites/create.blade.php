@extends('admin.layouts.default')
@section('content')

{{ Form::open(array('route'=>'website.store','method'=>'post'))}}
<div class="container">
<h1 >Create </h1>
<hr>
<div class="form-group">
{{ Form::label('domainName','DomainName')}}
{{ Form::text('domainName','', ['class'=>'form-control', 'required' => 'required']) }}
</div>  
<div class="form-group">
{{ Form::label('menuTag','MenuTag ')}} 
{{ Form::text('menuTag','',['class'=>'form-control', 'required' => 'required'])}}
</div>
<div class="form-group">
{{form::label('numberPage','NumberPage')}}
{{form::number('numberPage','',['class'=>'form-control', 'required' => 'required'])}}
</div>
<div class="form-group">
{{form::label('limitOfOnePage','LimitOfOnePage:')}}
{{form::number('limitOfOnePage','',['class'=>'form-control', 'required' => 'required'])}}
</div>
<div class="form-group">
{{form::label('stringFirstPage','StringFirstPage:')}}
{{form::text('stringFirstPage','',['class'=>'form-control', 'required' => 'required'])}}
</div>
<div class="form-group">
{{form::label('stringLastPage','StringLastPage:')}}
{{form::text('stringLastPage','',['class'=>'form-control'])}}
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

</div>
@stop