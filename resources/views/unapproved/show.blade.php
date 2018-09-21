@extends('layouts.app')

@section('content')
<div class="container-fluid" id="story-detail">
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

        <div class="col-md-9">
            <div class="row">
                <div class="col-12 story-title">
                    {!! $story->name !!} - {!! $story->chapter !!}
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-12 story-content" contenteditable="true">
                    {!! $story->content !!}
                </div>
                <button type="submit" class="btn btn-primary save-content" onclick="saveStory({{ $story->id }})"><i class="fas fa-download"></i>  Lưu lại</button>
                <button onclick="goBack()" class="btn btn-default back-btn"><i class="fas fa-arrow-left"></i>  Trở về </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var baseURL = "{{ url('/') }}";
    $(document).ready(function(){

    });

    function saveStory($id){
        var data = {
                id: $id,
                content: $('.story-content').html()
            };
        $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
                method : "POST",
                url: baseURL + "/unapproved/" + $id + "/store",
                data: data,
                success: function(response) {
                    var obj = $.parseJSON(response);
                    if(obj.Response=='Error')
                    {
                        alert('Error');
                    }else{
                        var list_languages = obj.result.name;
                        list_languages = list_languages.trim();
                        // $('.popupBox',_self).html(list_languages);
                        $(_self).attr('data-title', list_languages);
                        $('.customToolTip').html(list_languages);
                        $(".customToolTip").show();
                        // $(_self).tooltip('enable');
                    }
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
    }
</script>
@endsection