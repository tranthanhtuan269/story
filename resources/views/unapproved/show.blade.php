@extends('layouts.app')

@section('content')
<div class="container-fluid">
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

        <div class="col-md-9">
            <div class="row">
                <div class="col-12">
                    {!! $story->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection