<style type="text/css">
    @media screen and (max-width:767px) {
        .cropper-bg,.cropper-crop-box,.cropper-view-box>img{width:310px!important}
    }
</style>
<div class="row cropper-con">
    <div class="col-md-6 mt-5">
        <button class="cropAspect btn" value="1.777">16:9</button>
        <button class="cropAspect btn" value="1.333">4:3</button>
        <button class="cropAspect btn" value="1">1:1</button>
        <button class="cropAspect btn" value="0.666">2:3</button>
        <button class="cropAspect btn" value="0.5625">9:16</button>
        <button class="cropAspect btn btn-primary" value="Nan">Free</button>
        <div class="mt-2">

            <svg class="pull-left icon">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#info"></use>
            </svg>

            <small class="cf-note">Pinch or use the mouse scroll to zoom</small>
        </div>
    </div>

    <div class="col-md-6 mt-5">
        <div class="form-group pull-right mobile-clear">
            <button type="button" class="btn cf-button cropClose">Cancel</button>
            <button type="button" class="btn btn-success cf-button cropImage">Crop Image</button>
        </div>
    </div>
</div>