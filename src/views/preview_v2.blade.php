<!-- HTML heavily inspired by http://blueimp.github.io/jQuery-File-Upload/ -->
<div class="table table-striped col-md-12" class="files" id="previews">
    <div id="dropzone_template" class="file-row">
    <!-- This is used as the file preview template -->
        <div class="col-md-1 col-xs-3 has-top">
            <span class="preview">
            <img data-dz-thumbnail />
            </span>
        </div>
        <div class="col-md-7 col-xs-7 has-top" style="word-break:break-all;">
            <p class="name pd-10" data-dz-name></p>
            <strong class="error text-danger pd-10" data-dz-errormessage style="word-break:keep-all;"></strong>
        </div>
        <div class="col-md-1 col-xs-2 has-top">
            <p class="size error-rmv" data-dz-size></p>
            <div class="progress progress-striped active error-rmv" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
            <div class="progress-bar progress-bar-success error-rmv" style="width:0%;" data-dz-uploadprogress></div>
            </div>
        </div>
        <div class="col-md-3 colxsright col-xs-12 has-top">
            <button class="cropOpen error-rmv btn btn-dark data-for-dsbl cancel">
                <i class="glyphicon glyphicon-scissors"></i>
                <span>Crop</span>
            </button>
            <button data-dz-remove class="btn btn-danger cancel data-for-dsbl">
                <i class="glyphicon glyphicon-trash"></i>
                <span>Remove</span>
            </button>
            <strong class="hide cf-label" style="color: red;" data-remove-lbl>Failed!</strong>
            <label class="cf-label delete" style="color: #286c41;">Uploaded</label>
        </div>
        <div class="col-md-11 col-xs-12 col-md-offset-1 error-rmv has-bot" data-add-details>
            <div class="image-form" data-img-upload data-uuid>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="cf-label">Photographer</label>
                        <input type="text" id="contributor" name="contributor" class="cf-input" placeholder="Enter photographer&#39;s name, source, and/or brand">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="cf-label">Illustrator</label>
                        <input type="text" id="illustrator" name="illustrator" class="cf-input" placeholder="Enter artist&#39;s name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="cf-label">Contributor Fee</label>
                        <input type="text" id="contributor_fee" name="contributor_fee" class="cf-input" placeholder="Enter cost producing this photo">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="cf-label">Tags</label>
                        <input type="text" id="tags" name="tags" class="cf-input" placeholder="Add tag to this photo">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>