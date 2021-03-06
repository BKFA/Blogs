@extends('admin.layouts.index')

@section('style')

@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Update Post</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
            <div class="col-sm-12">
            	@if(count($errors) > 0)
				 	<div class="p-3 mb-3 rounded alert rounded box-shadow" style="background: #EE7C60 !important; font-size: 14px; margin-top: 10px;">
	            		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                    <strong>
		                    @foreach($errors->all() as $err)
			                  	{{$err}}<br>
			              	@endforeach()
	                	</strong>
	            	</div>
		        @endif
		        @if(session('loi'))
		        	<div class="p-3 mb-3 rounded alert rounded box-shadow" style="background: #EE7C60 !important; font-size: 14px; margin-top: 10px;">
	            		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                    <strong>
		                    {{session('loi')}}
	                	</strong>
	            	</div>
                @endif
		        @if(session('thongbao'))
		          	<div class="p-3 mb-3 rounded alert rounded box-shadow" style="background: #7DF5B4 !important; font-size: 14px; margin-top: 10px;">
	            		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
	                    <strong>{{session('thongbao')}}</strong>
	            	</div>
		        @endif
		    </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<!-- general form elements -->
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Form Update</h3>
					</div>
					<!-- /.card-header -->
					<!-- form start -->
					<form action="admin/post/update/{{$post->idpost}}" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{csrf_token()}}">
						<div class="card-body">
							<div class="form-group">
								<label>Topic</label>
								<select class="form-control" style="width: 100%;" name="idTopic">
									<option value="{{$post->idtopic}}">{{$post->topic->nametopic}}</option>
		                            @foreach ($topic as $tp)
		                            	@if($tp->idtopic != $post->idtopic)
											 <option value="{{$tp->idtopic}}">{{$tp->nametopic}}</option>
		                            	@endif
		                            @endforeach
								</select>
							</div>
							<div class="form-group">
								<label>Title</label>
								<input class="form-control" type="text" placeholder="Please enter Title" name="title" value="{{$post->title}}">
							</div>

							<div class="form-group">
			                  	<label>Multiple</label>
				                <select class="form-control tags" multiple="multiple" data-placeholder="Select a Enter Tag" style="width: 100%;" name="idTag[]">
									 @foreach ($tag as $tg)
										<option value="{{$tg->idtag}}" selected="selected">{{$tg->tag}}</option>
									@endforeach
									@php
									$len = count($tag);
				                	for($i = 0; $i < count($tags); $i++){
										$tmp = 0;
										for($j = 0; $j < count($tag); $j++){
											if($tags[$i]->idtag == $tag[$j]->idtag ) break;
											$tmp ++;
											if($tmp == $len){
												@endphp
						                			<option value="{{$tags[$i]->idtag}}">{{$tags[$i]->tag}}</option>
												@php
											}
										}
				                	}
				                	@endphp
								</select>
							</div>

							<div class="form-group">
								<label>Description</label>
								<textarea class="form-control" rows="5" placeholder="Enter Description ..." name="description">{{$post->description}}</textarea>
							</div>
							<div class="form-group">
								<label>Content Post</label>
								<textarea id="demo" name="content" class="form-control ckeditor" rows="10">{{$post->contentpost}}</textarea>
							</div>

							<div class="form-group">
                                <label>Ảnh</label>
                                <br>
                                <label>
                                    <input type="file" class="form-control" name="img" id="file" />
                                </label>
                                <div id="status_upload"></div>
                                <div class="preview">
                                    <div class="imgpreview" align="center">
                                        <img id="previewing" src="/upload/post/{{$post->urlimage}}" />
                                    </div>
                                    <div class="message"></div>
                                </div>
                            </div>
						</div>
						<!-- /.card-body -->
						<div class="card-footer">
							<button type="submit" class="btn btn-primary">Update <i class="fa fa-location-arrow"></i></button>
							<button type="reset" class="btn btn-primary">Reset <i class="fa fa-refresh"></i></button>
						</div>
					</form>
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('script')

<script>
    $(document).ready(function(){

    	$(".tags").select2({
		 	tags: true
		});

        var message = document.getElementsByClassName("message")[0];
	    var file_upload = document.getElementById('file');
	    // hiển thị ảnh nếu validation thành công
	    file_upload.addEventListener('change', function(e) {
	        var file = this.files[0];
	        var imagefile = file.type;
	        var match = ["image/jpeg", "image/png", "image/jpg"];
	        if (!((imagefile == match[0]) || (imagefile == match[1]) ||
	                (imagefile == match[2]))) {
	        	
	            message.innerHTML = "File phải có định dạng jpeg, jpg and png";
	            document.getElementById('previewing').style.display = "none";
	            return false;
	        } else {
	            message.innerHTML = "Chấp nhận";
	            var reader = new FileReader();
	            reader.onload = function imageIsLoaded(e) {
	                var previewing = document.getElementById('previewing');
	                previewing.style.display = "block";
	                previewing.setAttribute('src', e.target.result);
	                previewing.setAttribute('width', '500px');
	                previewing.setAttribute('height', '100%');
	            }
	            reader.readAsDataURL(this.files[0]);
	        }
	    });
        
    });

</script>

@endsection