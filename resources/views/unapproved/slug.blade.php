@extends('layouts.app')

@section('content')
        <div class="col-md-9" id="slug-unapproved-page">
            <div class="row">
                @foreach($stories as $index => $store )
                <div class="col-4 @if($index >= 3) mt-3 @endif ">
                    <div class="card" style="width: 14rem; height: 19rem;">
                    @if(strlen($store->avatar) > 0) 
                      <img class="card-img-top" src="{{ url('/') }}/images/stories/{{ $store->avatar }}" width="110" height="150" alt="Card image cap">
                    @else
                      <img class="card-img-top" src="{{ url('/') }}/images/220_300.jpg" width="110" height="150" alt="Card image cap">
                    @endif
                      <div class="card-body text-center">
                        <h5 class="card-title">{{ $store->name . ' - ' . $store->chapter }} <br /> <span style="color:red;">{{  $store->author }} </span></h5>
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
@endsection