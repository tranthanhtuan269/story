@extends('layouts.app')

@section('content')
<div class="col-md-9" id="home-page">
    <div class="row">
        @foreach($stories as $index => $story )
        <div class="col-4 @if($index >= 3) mt-3 @endif card-story">
            <div class="card" style="width: 14rem; height: 19rem;">
            @if($story->avatar == null)
              <img class="card-img-top" src="{{ url('/') }}/images/220_300.jpg"  width="110" height="150" alt="Card image cap">
              @else
              <img class="card-img-top" src="{{ url('/') }}/images/stories/{{ $story->avatar }}"  width="110" height="150" alt="Card image cap">
              @endif
              <div class="card-body">
                <h5 class="card-title">{{ $story->name }} <br /> <span style="color:red;">{{ $story->author }}</span></h5>
                {!! Form::open(['method' => 'Delete', 'route' => ['stories.destroy', $story->slug]]) !!}
                <a href="{{ url('/') }}/stories/{{ $story->slug }}" class="btn btn-primary">Chi tiết</a>
                <button type="submit" class="btn btn-danger">Xóa</button>
                {!! Form::close() !!}
              </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $stories->links() }}
</div>
<button onclick="goBack()" class="btn btn-default back-btn"><i class="fas fa-arrow-left"></i>  Trở về </button>
@endsection