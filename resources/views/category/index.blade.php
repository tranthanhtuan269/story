@extends('layouts.app')

@section('content')
<div class="col-md-9" id="category-index-page">
    <div class="row">
        @foreach($categories as $index => $category )
        <div class="col-4 @if($index >= 3) mt-3 @endif card-category">
            <div class="card" style="width: 14rem; height: 19rem;">
              <div class="card-body">
                <h5 class="card-title">{{ $category->name }}</h5>
                {!! Form::open(['method' => 'Delete', 'route' => ['categories.destroy', $category->id]]) !!}
                <a href="{{ url('/') }}/categories/{{ $category->id }}" class="btn btn-primary">Chi tiết</a>
                <button type="submit" class="btn btn-danger">Xóa</button>
                {!! Form::close() !!}
              </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $categories->links() }}
</div>
<button onclick="createNew()" class="btn btn-primary create-btn"><i class="fas fa-plus"></i>  Tạo mới </button>
<button onclick="goBack()" class="btn btn-default back-btn"><i class="fas fa-arrow-left"></i>  Trở về </button>
<script type="text/javascript">
  function createNew(){
    window.location.href = "{{ url('/') }}/categories/create";
  }
</script>
@endsection