@extends('layouts.app')

@section('content')
<div class="col-md-9" id="create-category">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        {!! Form::open(['method' => 'POST', 'route' => 'categories.store', 'id' => 'create-categories', 'class' => 'col-sm-12']) !!}
            <div class="form-group row">
                {{ Form::label("Name:", null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10"> 
                    {{ Form::text("name", null, ['class' => 'form-control']) }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="row">
        <button type="submit" class="btn btn-primary save-content" onclick="saveCategory()"><i class="fas fa-download"></i>  Lưu lại</button>
        <button onclick="goBack()" class="btn btn-default back-btn"><i class="fas fa-arrow-left"></i>  Trở về </button>
    </div>    
</div>
<script type="text/javascript">
    function saveCategory(){
        $('#create-categories').submit();
    }
</script>
@endsection