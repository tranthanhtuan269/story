@extends('layouts.app')

@section('content')
<div class="col-md-9" id="story-detail">
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