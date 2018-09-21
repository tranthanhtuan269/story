@extends('layouts.app')

@section('content')
<div class="container-fluid" id="slug-unapproved-page">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <ul class="list-group">
                <li class="list-group-item active">Danh mục</li>
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
                @foreach($stories as $index => $store )
                <div class="col-4 @if($index >= 3) mt-3 @endif ">
                    <div class="card" style="width: 18rem;">
                      <img class="card-img-top" src="{{ url('/') }}/svg/286x180.svg" alt="Card image cap">
                      <div class="card-body">
                        <h5 class="card-title">{{ $store->name . ' - ' . $store->chapter }}</h5>
                        <p class="card-text">{{ $store->author }}</p>
                        <a href="{{ url('/') }}/unapproved/{{ $store->id }}/edit" class="btn btn-primary">Chỉnh sửa</a>
                        <a href="{{ url('/') }}/unapproved/{{ $store->id }}/view" class="btn btn-primary">Chi tiết</a>
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