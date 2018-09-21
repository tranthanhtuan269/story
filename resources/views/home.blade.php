@extends('layouts.app')

@section('content')
<div class="container-fluid" id="home-page">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item active"><i class="far fa-list-alt"></i>  Danh mục</li>
                <li class="list-group-item">Chưa duyệt</li>
                <li class="list-group-item">Ngôn tình</li>
                <li class="list-group-item">Truyện teen</li>
                <li class="list-group-item">Kiếm hiệp</li>
                <li class="list-group-item">Tiên hiệp</li>
                <li class="list-group-item">Xuyên không</li>
                <li class="list-group-item">Đam mỹ</li>
                <li class="list-group-item">Sắc hiệp</li>
                <li class="list-group-item">Trinh thám</li>
                <li class="list-group-item">Truyện kinh dị</li>
            </ul>
        </div>

        <div class="col-md-9" id="main-content">
            <div class="row">
                @foreach($stories as $index => $story )
                <div class="col-4 @if($index >= 3) mt-3 @endif card-story">
                    <div class="card" style="width: 18rem;">
                    @if($story->avatar == null)
                      <img class="card-img-top" src="{{ url('/') }}/svg/286x180.svg" width="286" height="180" alt="Card image cap">
                      @else
                      <img class="card-img-top" src="{{ url('/') }}/images/stories/{{ $story->avatar }}" width="286" height="180" alt="Card image cap">
                      @endif
                      <div class="card-body">
                        <h5 class="card-title">{{ $story->name }}</h5>
                        <p class="card-text">{{ $story->author }}</p>
                        {!! Form::open(['method' => 'Delete', 'route' => ['unapproved.destroy', $story->slug]]) !!}
                        <a href="{{ url('/') }}/unapproved/{{ $story->slug }}" class="btn btn-primary">Chi tiết</a>
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
    </div>
</div>
@endsection