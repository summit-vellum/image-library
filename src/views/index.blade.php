@extends('vellum::modalExtend')

@push('css')
<link href="{{ asset('vendor/imagelibrary/css/dropzone/container-dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/imagelibrary/css/dropzone/dropzone.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/imagelibrary/css/cropper.css') }}" rel="stylesheet">
<link href="{{ asset('vendor/imagelibrary/css/image-multiple-upload.css') }}" rel="stylesheet">
@endpush

<style type="text/css"></style>

@section('head')
     <div class="px-3">
        @include('vellum::modal.header-buttons', ['rightBtnClass' => '', 'attributes' => arrayToHtmlAttributes(['id' => 'insertImage', 'disabled' => 'disabled'])])
    </div>
@endsection


@section('extend')
<form id="photo" method="post" autocomplete="off">
	<!-- put this alongside the javascript -- check custom.js -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="_method" value="put">
    <input type="hidden" name="target" value="{{ $target ?? '' }}">
    <input type="hidden" id="id" name="id">

    <h3>Image Details</h3>

    <div class="form-group">
        <label class="cf-label">Caption</label>
        <textarea id="caption" name="caption" class="cf-input" placeholder="Write your caption" rows="5"></textarea>
        <div class="mt-2">
            @icon(['icon' => 'info', 'classes' => 'pull-left'])
            <div class="pl-17">
                <small class="cf-note">The ideal length of an image caption is below 155 characters.</small>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="cf-label">Alt Text</label>
        <textarea id="alt_text" name="alt_text" class="cf-input" placeholder="Alternate text" rows="5"></textarea>
    </div>
    <div class="form-group">
        <label class="cf-label">Photographer</label>
        <input type="text" id="contributor" name="contributor" class="cf-input" placeholder="Photographer's name">
    </div>
    <div class="form-group">
        <label class="cf-label">Illustrator</label>
        <input type="text" id="illustrator" name="illustrator" class="cf-input" placeholder="Artist's name">
    </div>
    <div class="form-group">
        <label class="cf-label">Contributor Fee</label>
        <input type="text" id="contributor_fee" name="contributor_fee" class="cf-input" placeholder="1,000.00">
    </div>
    <div class="form-group">
        <label class="cf-label">Credit Label</label>
        <input type="text" id="credit_label" class="cf-input" placeholder="Credit's label">
    </div>
    <div class="form-group">
        <label class="cf-label">Link</label>
        <input type="text" id="credit_link" class="cf-input" placeholder="Credit's link">
    </div>
    <div class="form-group">
        <label class="cf-label">Tags</label>
        <textarea id="tags" name="tags" class="cf-input" placeholder="Add tag to this photo" rows="5"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" id="submit" name="submit" class="btn btn-success btn-block cf-button" value="Save Changes" disabled>
    </div>
</form>
@stop

@section('content')
<div class="container">
	<div class="px-3">
		<!-- header -->
		<div class="row mb-3">
			<ul class="nav nav-tabs">
				<li class="action active">
					<a href="#imageLibrary" data-toggle="tab">
						<label>Image Library</label>
					</a>
				</li>
				<li class="action">
					<a href="#uploadImage" data-toggle="tab">
                        <label>Upload Image</label>
                    </a>
				</li>
			</ul>
		</div>

		<!-- content -->
		<div class="row">
			<div class="tab-content px-2 py-2 mobile-modal-pl-0">
				<!-- Image library -->
                <div class="tab-pane active" id="imageLibrary">
                	<div class="row mb-3 px-1">
                		<form role="form" target="" autocomplete="off">
                			<div class="col-md-10 col-xs-12 px-0 mb-3">
                				@if(isset($_GET['keyword']))
                                <input type="text" class="cf-input" name="keyword" value="{{ $_GET['keyword'] }}" placeholder="Enter image name or tag to search">
                                @else
                                <input type="text" class="cf-input" name="keyword" placeholder="Enter image name or tag to search">
                                @endif
                			</div>
                			<div class="col-md-2 col-xs-12 px-0 mb-3">
                                <input type="hidden" name="target" value="{{ $target ?? '' }}">
                                <input type="submit" name="submit" value="Search" class="btn btn-primary btn-block cf-button">
                            </div>
                		</form>
                	</div>
                	<div id="imagelibrary-container" class="row library-container">
                        @if(count($images) >= 1)
                            @foreach ($images as $image)
                                <div class="thumbs thumbpost">
                                    <span class="delete-image remove-thumb" data-id="{{ $image->id }}" data-toggle="modal" data-target="#removeImage" data-ajax-modal>X</span>
                                    <img src="{{ $img_source.$image->path }}" class="selectImage" data-image="{{ $image }}">
                                </div>
                            @endforeach
                        @else
                            <div id="no-result" class="text-center h4 mt-3">
                                <i>No image found. Change your search parameters and try submitting again.</i>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Image upload -->
                <div class="tab-pane" id="uploadImage">
                	<div class="image-crop hide">
                		@include(template('cropper', [], 'image-library'), [])
                		<img id="img-cropper">
                		@include(template('cropper', [], 'image-library'), [])
                	</div>
                	<div class="image-upload">
	                	<div class="row">
	                		<div class="mt-2" style="padding-left:20px;padding-bottom:10px">
	                            @icon(['icon' => 'info', 'classes' => 'pull-left'])
	                            <div style="padding-left:17px">
	                                <small class="cf-note">Maximum file size of image is 0.5MB</small>
	                            </div>
	                        </div>

	                       <div class="col-md-12 text-center">
				                <form id="dropzone_v1" class="mb-3 dropzone fileinput-button estopprop">
				                  <input type="hidden" name="_method" value="post">
				                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				                  <input type="hidden" name="target" value="{{ $target }}">

				                  <div class="dz-message needsclick h4">
				                      <div class="text-center mb-2">
				                          @icon(['icon' => 'drag-drop', 'classes' => '', 'iconModule' => 'image-library'])
				                      </div>
				                      <span class="d-block color-silver-chalice"><u class="color-azure-radiance">browse your computer</u></span>
				                  </div>
				                </form>
				            </div>
	                	</div>

	                	<div class="row">
                          <div class="col-md-12 text-center mr-b-20">
                            <button class="btn btn-primary data-for-dsbl hide estopprop" id="data-upld-all" data-btn>
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Upload All</span>
                            </button>
                            <button type="reset" class="btn btn-danger data-for-dsbl hide" id="data-rmv-all" data-btn>
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Remove All</span>
                            </button>
                            </div>
                        </div>

                        <div class="row col-md-13 text-center hide" id="goto-library" data-goto-library>
                            <button class="btn btn-success btn-lg estopprop" id="">
                                <i class="glyphicon glyphicon-eye-open"></i>
                                <span>View Image Library</span>
                            </button>
                        </div>

                        <div class="row" data-img-container>
                            <br>
                            @include(template('preview_v2', [], 'image-library'), [])
                        </div>

                        <div class="col-md-5 col-md-offset-1 mt-3 upload-con">
                            <div class="form-group">
                                <button type="button" class="btn btn-success btn-block cf-button hide" id="saveImage">Upload All</button>

                            </div>
                        </div>

                        <div class="col-md-5 mt-3 upload-con">
                            <div class="form-group">
                                <button type="button" class="btn btn-block cf-button uploadMore hide">Upload More</button>
                            </div>
                        </div>

                        <div class="col-md-4 col-md-offset-4 mt-3 upload-con">
                            <div class="form-group">
                                <button type="button" class="btn btn-block cf-button goto-library hide" onclick="location.reload();">Image Library</button>
                            </div>
                        </div>
	                </div>
                </div>

			</div>
			<input type="hidden" id="action" value="#internal">
		</div>
	</div>
</div>
@endsection


@push('scripts')
<script src="{{ asset('vendor/imagelibrary/js/jquery-cropper/cropper.js') }}"></script>
<script src="{{ asset('vendor/imagelibrary/js/jquery-cropper/jquery-cropper.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/imagelibrary/js/dropzone/dropzone.js') }}"></script>
{!! Html::script(asset('vendor/imagelibrary/js/imagelibrary.js'), ['data-imgLib-url' => url('/image-library/feed'),
'data-imgLib-token' => csrf_token(),
'data-imgLib-site' => $code_name,
'data-imgLib-target' => $target,
'data-imgLib-route' => route('imagelibrary.destroy', ''),
'data-imgLib-source' => $img_source],
false) !!}

<!-- TRANSFER TO ANOTHER JS FILE -->
<script type="text/javascript">
	var imagelibraryUrl = '/image-library/feed?page=2',
    img_source = '{{ $img_source }}',
    keywordInput = $('input[name="keyword"]'),
    keywordValue = '&keyword='+keywordInput.val(),
    stopper = 0;

if(keywordInput.val().length > 0){
    imagelibraryUrl = imagelibraryUrl+keywordValue;
}

$('#imagelibrary-container').on('scroll', function(){
    var scrollTop = $(this).scrollTop(),
        innHeight = $(this).innerHeight(),
        container = $('#imagelibrary-container'),
        lastChild = container.find('.thumbs:last-child'),
        lastTopChild = lastChild.position().top;

    if( Math.ceil(scrollTop + innHeight) >= $(this)[0].scrollHeight && !stopper) {
    	//CHANGE TO ajaxPartialUpdate
        $.ajax({
            type: "GET",
            async: false,
            url: imagelibraryUrl,
            success: function (response) {

                imagelibraryUrl = response.images.next_page_url;

                if(imagelibraryUrl){
                    imagelibraryUrl = imagelibraryUrl+keywordValue;
                    var images = response.images.data;
                    var imageString = '';

                    $.each(images, function(index, image){
                        imageString += '<div class="thumbs thumbpost"><img src="' + img_source + ((image.path.charAt(0)) == '/' ? image.path : '/' + image.path)+'" data-id="'+image.id+'" data-image=\''+JSON.stringify(image)+'\' class="selectImage" height="150" width="150"></div>';
                    });

                    container.append(imageString);
                }
                else{
                    stopper = 1;
                }
            }
        });
    }
});

 $(document).on("click", '.selectImage', function() {
    // toggle image selector
    $(".selectImage").removeClass("thumb-selected");
    $(this).addClass("thumb-selected");
    // toggle image details
    $('.modal-dialog', parent.document.body).addClass('modal-extended');

    $(this).parents('div.modal-content-right').addClass('mcr');
    $('.modal-content-left').removeClass('mcl');
    $('.modal-content-left').addClass('modalview');
    $('.extend-details').find('svg').css({transform: 'rotate(0)'});

    // display image details
    var image = $(this).data('image');
    $('form#photo').prop('action', "{{ url('image-library/feed') }}/"+image.id);
    $('form#photo').find('#id').val(image.id);
    $('form#photo').find('#contributor').val(image.contributor);
    $('form#photo').find('#illustrator').val(image.illustrator);
    $('form#photo').find('#contributor_fee').val(image.contributor_fee);
    $('form#photo').find('#credit_label').val(image.credit_label);
    $('form#photo').find('#credit_link').val(image.credit_link);
    $('form#photo').find('#tags').val(image.tags);
    $('form#photo').find('#alt_text').val(image.alt_text);
    $('#submit').prop('disabled', false);
    // enable add to content button
    $('#insertImage').prop('disabled', false);

}).on("click", ".delete-image", function(){
    var thumb = $(this).closest('.thumbs');
    var imgId = $(this).data('id');
    var modal = $(this).data('target');

    window.parent.$(modal).addClass('in').css({'background':'#00000078', 'z-index':'1051'}).show();

    window.parent.$(modal+',[data-dismiss="modal"]').click(function(){
        window.parent.$(modal).removeClass('in').removeAttr('style').hide();
    });

    window.parent.$(modal).find('[data-modal-continue]').click(function(e){
    	console.log('data-modal-continue triggered');
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: {"_token":"{{ csrf_token() }}","_method":"delete"},
            url: "{{ route('imagelibrary.destroy', '') }}/"+imgId,
            success: function (response) {
            	$(thumb).remove();
                window.parent.$('[data-dismiss="modal"]').click();
            }
        });
    })
});

//JS ABOVE COMPARE WITH IMAGELIBRARY.JS
//ADD CSS TO TINYMCE LIKE IN QUILL
 function insertImage(target, index, image){
    var imageId = image.id;
    var imagePath = image.path;
    var imageContributor = image.contributor;
    var imageIllustrator = image.illustrator;
    var imageCreditLabel = $('form#photo').find('#credit_label').val();
    var imageCreditLink = $('form#photo').find('#credit_link').val();
    var imageCaption = $('form#photo').find('#caption').val();
    var imageSource = "{{ $img_source }}" + imagePath;
    var imageAltText = $('form#photo').find('#alt_text').val();
    // check if insert to tinymce or not

    if(target=='tinymce' || target=='tinymceMini' ){

        if(target=='tinymce')
        {
            data = '<figure class="article__photo">';
            data += '<div class="card">';
            data += '<div class="card__figure">';
            data += '<img src="'+imageSource+'" alt="'+imageAltText+'">';
            data += '</div>';
            data += '</div>';


            if(imageCaption != '' || imageContributor != '' || imageIllustrator != '' || imageCreditLabel != '' || imageCreditLink != '' )
            {
                data += '<figcaption class="caption"> ';
                data += '<div class="card">';
                data += '<div class="card__figure">';
                data += '<svg class="icon icon--button"> <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#camera"></use> </svg>';
                data += '</div>';
                data += '<div class="card__body">';

                if(imageCaption)
                {
                    data += '<span data-caption="">'+imageCaption+'</span> ';
                }

                if(imageContributor)
                {
                    data += '<span class="credits" data-photographer="">'+imageContributor+'</span> ';
                }

                if(imageIllustrator)
                {
                    data += '<span class="credits" data-illustrator="">'+imageIllustrator+'</span> ';
                }

                if(imageCreditLink || imageCreditLabel)
                {
                    if(imageCreditLabel == '') imageCreditLabel = imageCreditLink;
                    if(imageCreditLink == '') imageCreditLink = '#';

                    data += '<a href="'+imageCreditLink+'" target="_blank" class="credits" data-credits="">'+imageCreditLabel+'</a>';
                }

                data += '</div>';
                data += '</div>';
                data += '</figcaption>';
            }

            data += '</figure>';
        }
        else
        {
            data  = '<img src="'+imageSource+'" data-caption="'+imageCaption+'" data-photographer="'+imageContributor+'"  data-illustrator="'+imageIllustrator+'" data-credit-label="'+imageCreditLabel+'" data-credit-link="'+imageCreditLink+'">';
        }

        data += '<br/>';

        parent.tinymce.activeEditor.execCommand('mceInsertContent', false, data);
    }

    $('[close-modal]').click();
}
</script>
@endpush
