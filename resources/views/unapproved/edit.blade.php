@extends('layouts.app')

@section('content')
<script src="http://jcrop-cdn.tapmodo.com/v0.9.12/js/jquery.Jcrop.min.js"></script>
<script src="https://unpkg.com/sweetalert2@7.12.16/dist/sweetalert2.all.js"></script>
<div class="col-md-9 form-content" id="story-edit">
    <div class="row">
        {!! Form::open(['method' => 'POST', 'route' => ['unapproved.update', $story->id], 'id' => 'edit-unapproved', 'class' => 'col-sm-12', 'files' => true]) !!}
            @method('PUT')
            <div class="form-group row">
                <div class="col-sm-10"> 
                    <div class="avatar">
                        <img id="image-loading" src="{{ asset('images/bx_loader.gif') }}" width="220" height="300" style="display: none;position: absolute;top: 35%;left: 45%;">
                        <input type="hidden" id="avatar" name="avatar" value="{{ $story->avatar }}">
                        @if(strlen($story->avatar) > 0)
                            <img src="{{ url('/') }}/images/stories/{{ $story->avatar }}"  width="110" height="150" id="avatar-image" class="img">
                        @else
                            <img src="{{ url('/') }}/images/220_300.jpg" id="avatar-image"  width="110" height="150" class="img">
                        @endif
                    </div>
                    <div class="btn btn-primary" id="change-avatar-btn">Đổi ảnh đại diện</div>
                    <div class="text-danger"><b>Chú ý: </b>Kích thước ảnh nên trong khoảng 160x160 tới 3000x3000 pixels</div>
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label("Name:", null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10"> 
                    {{ Form::text("name", $story->name, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label("Author:", null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10"> 
                    {{ Form::text("author", $story->author, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label("link:", null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10"> 
                    {{ Form::text("link", $story->link, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label("chapter:", null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10"> 
                    {{ Form::text("chapter", $story->chapter, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="form-group row">
                {{ Form::label("category:", null, ['class' => 'col-sm-2 col-form-label']) }}
                <div class="col-sm-10"> 
                    {{ Form::select('category', $categories, '1', ['class' => 'form-control'])}}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
    <div class="row">
        <button type="submit" class="btn btn-danger approve-content" onclick="approveStory({{ $story->id }})"><i class="fas fa-check"></i>  Duyệt</button>
        <button type="submit" class="btn btn-primary save-content" onclick="saveStory({{ $story->id }})"><i class="fas fa-download"></i>  Lưu lại</button>
        <button onclick="goBack()" class="btn btn-default back-btn"><i class="fas fa-arrow-left"></i>  Trở về </button>
    </div>    
</div>
<!-- Modal -->
<div id="change-avatar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg modal-image">
    <!-- Modal content-->
    <div class="modal-content">
        <form id="form" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select new avatar</h4>
            </div>
            <div class="modal-body">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar"
                    aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
                        80%
                    </div>
                </div>
                <input id="file" type="file" class="hide" accept="image/*">
                <div id="views"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="load-btn">Load image</button>
                <button type="button" class="btn btn-primary hide" id="submit-btn">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
  </div>
</div>

<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v0.9.12/css/jquery.Jcrop.min.css" type="text/css" />
<script type="text/javascript">
    var baseURL = "{{ url('/') }}";
    $(document).ready(function(){
        var $file = null;

        $('#change-avatar').on('shown.bs.modal', function (e) {
            e.preventDefault();
            var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
            if ($.inArray($($file).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                swal({
                    html: '<div class="alert-danger">Only formats are allowed : '+fileExtension.join(', ')+'</div>',
                  })
                return;
            }
            loadImage($file);
        });
        
        var crop_max_width = 220;
        var crop_max_height = 300;
        var jcrop_api;
        var canvas;
        var context;
        var image;

        var prefsize;

        $('#avatar-image').click(function(){
            $('#file').val("");
            $('#file').click();
        });

        $("#file").change(function() {
            $file = this;
            if($(this).val().length > 0){
                $('.progress').removeClass('hide');
                loadImage(this);
            }
        });

        $('#load-btn').click(function(){
            $('#file').val("");
            $('#change-avatar').modal('hide');
            $('#file').click();
        });

        $('#change-avatar-btn').click(function(){
            $('#file').val("");
            $('#file').click();
        });

        function loadImage(input) {
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            canvas = null;
            reader.onload = function(e) {
              image = new Image();
              image.onload = validateImage;
              image.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            $('#submit-btn').removeClass('hide');
          }
        }

        function validateImage() {
            $('.progress').addClass('hide');
            if (canvas != null) {
                image = new Image();
                image.onload = restartJcrop;
                image.src = canvas.toDataURL('image/png');

                $("#form").submit();
            } else restartJcropOpen();
        }

        function restartJcropOpen() {
            if(image.width < 160 || image.height < 160 || image.width > 3000 || image.height > 3000){
                $("#views").empty();
                swal({
                    html: '<div class="alert-danger">Kích thước ảnh nên trong khoảng 160x160 tới 3000x3000 pixels</div>',
                });
              }else{
                $('#change-avatar').modal('show');
                restartJcrop();
              }
        }

        function restartJcrop() {
          if (jcrop_api != null) {
            jcrop_api.destroy();
          }
          $("#views").empty();
          $("#views").append("<canvas id=\"canvas\">");
          canvas = $("#canvas")[0];
          context = canvas.getContext("2d");
          canvas.width = image.width;
          canvas.height = image.height;
          var imageSize = (image.width > image.height)? image.height : image.width;
          imageSize = (imageSize > 800)? 800: imageSize;
          context.drawImage(image, 0, 0);
          $("#canvas").Jcrop({
            onSelect: selectcanvas,
            onRelease: clearcanvas,
            boxWidth: crop_max_width,
            boxHeight: crop_max_height,
            setSelect: [0,0,imageSize,imageSize],
            aspectRatio: crop_max_width/crop_max_height,
            bgOpacity:   .4,
            bgColor:     'black'
          }, function() {
            jcrop_api = this;
          });
          clearcanvas();
          selectcanvas({x:0,y:0,w:imageSize,h:imageSize});
        }

        function clearcanvas() {
          prefsize = {
            x: 0,
            y: 0,
            w: canvas.width,
            h: canvas.height,
          };
        }

        function selectcanvas(coords) {
          prefsize = {
            x: Math.round(coords.x),
            y: Math.round(coords.y),
            w: Math.round(coords.w),
            h: Math.round(coords.h)
          };
        }

        $('#submit-btn').click(function(){
            canvas.width = prefsize.w;
            canvas.height = prefsize.h;
            context.drawImage(image, prefsize.x, prefsize.y, prefsize.w, prefsize.h, 0, 0, canvas.width, canvas.height);
            validateImage();
        });

        $("#form").submit(function(e) {
          e.preventDefault();
          $('#change-avatar').modal('hide');
          formData = new FormData($(this)[0]);
          formData.append("base64", canvas.toDataURL('image/png'));

          $.ajaxSetup(
          {
              headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ url('/') }}/images/uploadImage",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $("#image-loading").show();
            },
            success: function(data) {
                if(data.code == 200){
                    $('#avatar-image').attr('src', "{{ url('/') }}/images/stories/" + data.image_url);
                    $('#avatar').val(data.image_url);
                    $('#change-avatar').modal('hide');
                    $("#views").empty();
                }else{
                    swal({
                        html: '<div class="alert-danger">Có lỗi xảy ra trong quá trình upload ảnh</div>',
                      })
                    return;
                }
                $('#avatar-image').on('load', function () {
                    $("#image-loading").hide();
                });
            },
            error: function(data) {
                alert("Error");
            },
            complete: function(data) {}
          });
        });
    });

    function saveStory($id){
        $('#edit-unapproved').submit();
    }

    function approveStory($id){
        var data = {
            id: $id,
            name: $("input[name=name]").val(),
            author: $("input[name=author]").val(),
            avatar: $("input[name=avatar]").val(),
            link: $("input[name=link]").val(),
            chapter: $("input[name=chapter]").val(),
            category: $('select[name=category]').find(":selected").val()
        };

        $.ajaxSetup(
          {
              headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $.ajax({
            url: "{{ url('/') }}/unapproved/"+$id+"/approve",
            type: "POST",
            data: data,
            success: function(data) {
                if(data.status_code == 201){
                    swal({
                        html: '<div class="alert-success">Duyệt truyện thành công!</div>',
                      });
                    window.location.href = "{{ url('/') }}/home";
                    return;
                }else{
                    swal({
                        html: '<div class="alert-danger">Có lỗi xảy ra trong quá trình xử lý</div>',
                      })
                    return;
                }
            },
            error: function(data) {
                alert("Error");
            },
            complete: function(data) {}
          });
    }
</script>
@endsection