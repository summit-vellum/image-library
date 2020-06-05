var siteCodename = $('[data-imgLib-site]').data('imglibSite');
var myDropzone;
var pageDetails = $('[data-imgLib-site]').data('imglibDetails');

/* Image uploader */
Dropzone.autoDiscover = false;
jQuery(document).ready(function() {

    var $image = $('#img-cropper');
    var selectedFile;
    var cropper;
    var imageLibraryBtn;

    function initCropper(cropperOptions){
        $image.cropper('destroy').cropper(cropperOptions);
        cropper = $image.data('cropper');
    }

    $(document).on('click', '.uploadMore', function(e){
        $('#dropzone_v1').get(0).dropzone.hiddenFileInput.click();
    });

    $(document).on('click', '.cropAspect', function(){

        var aspectIndex = $(this).index();

        $('.cropper-con').each(function(e){

            var currentAspect = $(this).find('.cropAspect').eq(aspectIndex).addClass('btn-primary');
            $(this).find('.cropAspect').not(currentAspect).removeClass('btn-primary');
        });

        initCropper({aspectRatio:$(this).val(), autoCropArea: 1, viewMode:1});
    });

    $(document).on('click', '.cropOpen', function(e){
        e.stopPropagation();

        var tag = this.tagName;

        var index = $(tag+'.cropOpen').index(this);

        selectedFile = myDropzone.files[index];

        var img=document.getElementById("img-cropper");

        img.file = selectedFile;

        var reader = new FileReader();

        reader.onload = (function(aImg) {

            return function(e) {

                aImg.src = e.target.result;

                $('.image-upload').addClass('hide');

                $('.image-crop').removeClass('hide');

                $image.css({'height':'auto', 'max-width':'100%', 'width':'100%'});

                $('.cropAspect').last().trigger('click');
            };

        })(img);

        reader.readAsDataURL(selectedFile);

    });

    $('.cropClose').click(function(){
        $('.image-upload').removeClass('hide');
        $('.image-crop').addClass('hide');
        $image.cropper('destroy');
    });



    function retainCropFields(file, data = false) {

        var uploadUuid = file.upload.uuid,
            c = $('#contributor_'+uploadUuid).val(),
            i = $('#illustrator_'+uploadUuid).val(),
            cf = $('#contributor_fee_'+uploadUuid).val(),
            t = $('#tags_'+uploadUuid).val();

        if (data) {
            var targetUUID = uploadUuid;

            var
                contributor = $('#contributor'),
                illustrator = $('#illustrator'),
                contributor_fee = $('#contributor_fee'),
                tags = $('#tags');

            contributor.attr('id', 'contributor_'+targetUUID);
            illustrator.attr('id', 'illustrator_'+targetUUID);
            contributor_fee.attr('id', 'contributor_fee_'+targetUUID);
            tags.attr('id', 'tags_'+targetUUID);

            $('#contributor_'+targetUUID).val(data.c);
            $('#illustrator_'+targetUUID).val(data.i);
            $('#contributor_fee_'+targetUUID).val(data.cf);
            $('#tags_'+targetUUID).val(data.t);
        }
        else{
            return {uploadUuid:uploadUuid,c:c,i:i,cf:cf,t:t};
        }
    }

    $('.cropImage').click(function(){

        // Turn the canvas into a Blob (file object without a name)
        cropper.getCroppedCanvas().toBlob(function(blob) {

            // Create a new Dropzone file thumbnail
            myDropzone.createThumbnail(
                blob,
                myDropzone.options.thumbnailWidth,
                myDropzone.options.thumbnailHeight,
                myDropzone.options.thumbnailMethod,
                false,
                function(dataURL) {

                    // Update the Dropzone file thumbnail
                    myDropzone.emit('thumbnail', selectedFile, dataURL);
                    // Return the file to Dropzone
                    //done(blob);
                    //
                    blob.name = selectedFile.name;

                    $('.cropClose').trigger('click');

                    var retArray = retainCropFields(selectedFile);

                    myDropzone.removeFile(selectedFile);

                    myDropzone.addFile(blob);

                    retainCropFields(blob,retArray);
            });

        }, 'image/jpeg', 0.95);

    });

    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    var previewNode = document.querySelector("#dropzone_template");
    // previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    myDropzone = new Dropzone('#dropzone_v1', { // Make the whole body a dropzone
      url: $('[data-imgLib-site]').data('imglibUrl'), // Set the url
      thumbnailWidth: 65,
      thumbnailHeight: 70,
      parallelUploads: 1,
      maxFilesize: 0.5, // MB
      acceptedFiles: "image/*",
      previewTemplate: previewTemplate,
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: "#previews", // Define the container to display the previews
      clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    });

    myDropzone.on("addedfile", function(file) {
      var _i, _len;

      for (_i = 0, _len = this.files.length; _i < _len - 1; _i++) // -1 to exclude current file
      {
        if(this.files[_i].name === file.name && this.files[_i].size === file.size && this.files[_i].lastModifiedDate.toString() === file.lastModifiedDate.toString())
        {
          this.removeFile(file);
        }
      }
      // file.previewElement.id = file.upload.uuid;
      if(file.size > 500000){
        file.previewElement.querySelectorAll(".error-rmv").forEach(function(e){
          e.classList.add('hide');
          $(e).parents('div #dropzone_template').find('.col-md-7').addClass('has-bot');
        });
        file.previewElement.querySelectorAll(".error-rmv").forEach(function(e){$(e).find('input').remove()});
      }
      else{
          $('[data-btn]').removeClass('hide');

          file.previewElement.querySelectorAll(".cf-input").forEach(function(e){
            var getId = e.getAttribute('id'),
              setId = e.setAttribute('id',getId+'_'+file.upload.uuid);
          });
      }
    });

    // Update the total progress bar
    // myDropzone.on("totaluploadprogress", function(progress) {
    //   document.querySelector(".progress-bar").style.width = progress + "%";
    // });

    myDropzone.on("removedfile", function(file) {
      if (this.files.length == 0) {
        $('[data-btn]').addClass('hide');
      }
    });

    myDropzone.on("sending", function(file, xhr, data) {
      // Show the total progress bar when upload starts
      // document.querySelector("#total-progress").style.opacity = "1";
      // And disable the start button

      data.append("contributor", $('#contributor_'+file.upload.uuid).val());
      data.append("illustrator", $('#illustrator_'+file.upload.uuid).val());
      data.append("contributor_fee", $('#contributor_fee_'+file.upload.uuid).val());
      data.append("tags", $('#tags_'+file.upload.uuid).val());

      $('.data-for-dsbl').attr('disabled', 'disabled');
    });

    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
      if(imageLibraryBtn) {
        $('[data-btn]').addClass('hide');
        $('#goto-library').removeClass('hide');
        $('#dropzone_v1').addClass('hide');
        $('[data-goto-library]').click(function(){
            location.reload();
        });
        $('[data-toggle]').first().click(function(){
            location.reload();
        });
      }
      // document.querySelector("#total-progress").style.opacity = "0";
    });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#data-upld-all").onclick = function() {
      imageLibraryBtn = true;
      document.querySelectorAll(".cropOpen").forEach(function(e){
          var hasHide =  e.classList.contains('hide');
          if(hasHide){
            $(e).parent('div').find('[data-remove-lbl]').removeClass('hide');
            $(e).parent('div').find('[data-dz-remove]').addClass('hide');
          }
      });

      myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
      $('[data-add-details]').addClass('hide');
    };
    document.querySelector("#data-rmv-all").onclick = function() {
      myDropzone.removeAllFiles(true);
    };
    $('.estopprop').on('click', function(e){
      e.preventDefault();
    });
});

function unique(list) {
    var result = [];
    $.each(list, function(i, e) {
        if ($.inArray(e, result) == -1) result.push(e);
    });
    return result;
}

/* Image insert */
$("#insertImage").on("click", function() {
    var target = $('[data-imgLib-site]').data('imglibTarget');
    var index = $("#"+target+"Index", parent.document.body).val();
    var image = $('.thumbs').find('.thumb-selected').data('image');
    // hidden reference index in parent container
    index = (index) ? index : 0;
    insertImage(target, index, image);
});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    e.target // activated tab
    e.relatedTarget // previous tab
    var version = $(e.target).attr('href').replace('#', '');

    if(version=='uploadImage'){
        $('.extend-details').trigger('click');
        $('#insertImage').addClass('hide');
        $('.modal-content-left').addClass('disabled');
        $('.modal-dialog', parent.document.body).removeClass('modal-extended');
    }else{
        $('#insertImage').removeClass('hide');
        $('.modal-content-left').removeClass('disabled');
    }
});
