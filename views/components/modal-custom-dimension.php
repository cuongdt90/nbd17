<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div id="dg-custom-dimension"  class="modal fade nbdesigner_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 15px;">
                <b>{{(langs['CHOOSE_DIMENSION']) ? langs['CHOOSE_DIMENSION'] : "Choose dimension"}}</b>
                <button style="margin-top: 0;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
            </div>            
            <div class="modal-body" style="padding: 15px;">
                <div class="form-group">
                    <label style="min-width: 150px;">{{(langs['WIDTH']) ? langs['WIDTH'] : "Width"}} <small>({{settings['nbdesigner_dimensions_unit']}})</small></label>
                    <input class="form-control hover-shadow dimensions nbdesigner_image_url" ng-model="customWidth"  placeholder="{{currentVariant.info[0].source.real_width}}"/>
                    &nbsp;<small>Min: {{productOptions.min_width}}</small>, <small>Max: {{productOptions.max_width}}</small>
                </div>
                <div class="form-group">
                    <label style="min-width: 150px;">{{(langs['HEIGHT']) ? langs['HEIGHT'] : "Height"}} <small>({{settings['nbdesigner_dimensions_unit']}})</small></label>
                    <input class="form-control hover-shadow dimensions nbdesigner_image_url" ng-model="customHeight"  placeholder="{{currentVariant.info[0].source.real_height}}"/>
                    &nbsp;<small>Min: {{productOptions.min_height}}</small>, <small>Max: {{productOptions.max_height}}</small>
                </div>   
                <div class="form-group">
                    <button type="button" class="btn btn-primary shadow nbdesigner_upload"  ng-click="changeDimension()"><i class="fa fa-check" aria-hidden="true"></i> OK</button>
                </div>
            </div>
        </div>
    </div>
</div>