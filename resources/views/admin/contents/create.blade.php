@extends('admin.layouts.default')
<!-- declase the ingredient of layout master -->
@section('Title','get persional list')
@section('content')
    
  <h1 >Create </h1><hr>
  <div class="row">
    @if(Session::has('ketqua')) 

        <p class="alert alert-success">{{Session::get('ketqua')}}</p>

    @endif
</div>
 
 {{ Form::open(array('route'=>'content.store','method'=>'post'))}}
  <div class="form-group">
    {{ Form::label('domainName','domainName') }}
    {{ Form::select('domainName', $rsss, null, ['class' => 'form-control', 'placeholder' => 'Chọn DomainName']) }}
  </div>
  <div class="form-group">
    {{ Form::label('title','title ')}}
    {{ Form::text('title','',['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('link','link')}}
    {{form::text('link','',['class'=>'form-control'])}}
  </div>
  <div class="form-group">
    {{form::label('description','description:')}}
    {{form::textarea('description','',['class'=>'form-control', 'rows' => 5])}}
  </div>
  <div class="form-group">
    {{form::label('body','body:')}}
    {{form::textarea('body','',['class'=>'form-control', 'rows' => 10])}}
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