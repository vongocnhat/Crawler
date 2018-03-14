@extends('admin.layouts.default')
<!-- declase the ingredient of layout master -->
@section('Title','keyword')
@section('content')
   {{ Form::model($edit,array('route'=>array('keyword.update',$edit->id),'method'=>'put'))}}
    <div class="container-fluid">
  <h1 >Edit </h1>
  <hr>
  <div class="row">
    @if(Session::has('ketqua')) 

        <p class="alert alert-success">{{Session::get('ketqua')}}</p>

    @endif
</div>
  

<div class="form-group">
{{ Form::label('name','name')}}
</div>
<div class="form-group"> 
{{ Form::text('name',$edit->name, ['class'=>'form-control']) }}
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
</div>

</div>
</div>
</div>
  {!! Form::close() !!}
@stop