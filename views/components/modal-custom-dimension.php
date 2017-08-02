<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div id="dg-custom-dimension"  class="modal fade nbdesigner_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 15px;">
                <b>{{(langs['CHOOSE_DIMENSION']) ? langs['CHOOSE_DIMENSION'] : "Choose dimension"}}</b>
                <button style="margin-top: 0;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
            </div>            
            <div class="modal-body" style="padding: 15px;">
                <form name="dimensionForm">
                    <div ng-show="productOptions.type_dimension == 1">
                        <div class="form-group">
                            <label style="min-width: 200px;">{{(langs['WIDTH']) ? langs['WIDTH'] : "Width"}} <small>({{settings['nbdesigner_dimensions_unit']}})</small></label>
                            <input class="form-control hover-shadow dimensions nbdesigner_image_url" step="any" type="number" min="{{productOptions.min_width}}" name="customWidth" ng-model="customWidth"  placeholder="{{currentVariant.info[0].source.real_width}}" required/>
                            &nbsp;<small>Min: {{productOptions.min_width}}</small>, <small>Max: {{productOptions.max_width}}</small>
                        </div>
                        <div class="form-group">
                            <label style="min-width: 200px;">{{(langs['HEIGHT']) ? langs['HEIGHT'] : "Height"}} <small>({{settings['nbdesigner_dimensions_unit']}})</small></label>
                            <input class="form-control hover-shadow dimensions nbdesigner_image_url" step="any" type="number" min="{{productOptions.min_height}}" name="customHeight" ng-model="customHeight"  placeholder="{{currentVariant.info[0].source.real_height}}" required/>
                            &nbsp;<small>Min: {{productOptions.min_height}}</small>, <small>Max: {{productOptions.max_height}}</small>
                        </div> 
                        <div class="form-group">
                            <label style="min-width: 200px;">{{(langs['NUMBER_OF_SIDE']) ? langs['NUMBER_OF_SIDE'] : "Number of sides/pages"}} </label>
                            <input type="number" step="1" min="1" class="form-control hover-shadow dimensions nbdesigner_image_url" name="customSide" ng-model="customSide"  placeholder="{{currentVariant.info.length}}" required/>
                        </div>  
                        <div class="form-group">
                            <button ng-disabled="!(dimensionForm.customWidth.$valid && dimensionForm.customHeight.$valid && dimensionForm.customSide.$valid)" type="button" class="btn btn-primary shadow nbdesigner_upload"  ng-click="changeDimension()"><i class="fa fa-check" aria-hidden="true"></i> OK</button>
                            <button ng-show="originProduct.length > 0" type="button" class="btn btn-primary shadow nbdesigner_upload" ng-click="reverseDimension()"><i class="fa fa-undo" aria-hidden="true"></i> Reverse</button>
                            <button style="background: #fff; border-radius: 0;" type="button" class="btn hover-shadow shadow"  ng-click="cancelDimension()"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                        </div>                        
                    </div>    
                    <div ng-show="productOptions.type_dimension == 2" style="margin-bottom: 15px;">
                        <div class="form-group">
                            <label style="min-width: 200px;">{{(langs['CHOOSE_DIMENSION']) ? langs['CHOOSE_DIMENSION'] : "Choose dimension"}} </label>
                            <div class="btn-group nbd-dropdown-option">
                                <button class="btn btn-primary dropdown-toggle shadow hover-shadow" type="button" data-toggle="dropdown">{{currentDimension}}&nbsp;&nbsp;<span class="caret"></span></button>
                                <ul class="dropdown-menu dropup  shadow hover-shadow">
                                    <li ng-repeat="dim in productOptions.defined_dimension"><a href="javascript:void(0);" ng-click="_changeDimension(dim)">{{dim.width + ' x ' + dim.height + ' ' + settings['nbdesigner_dimensions_unit']}}</a></li>                                    
                                </ul>  
                            </div> 
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary shadow nbdesigner_upload"  ng-click="changeDimension()"><i class="fa fa-check" aria-hidden="true"></i> OK</button>
                            <button ng-show="originProduct.length > 0" type="button" class="btn btn-primary shadow nbdesigner_upload" ng-click="reverseDimension()"><i class="fa fa-undo" aria-hidden="true"></i> Reverse</button>
                            <button style="background: #fff; border-radius: 0;" type="button" class="btn hover-shadow shadow"  ng-click="cancelDimension()"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                        </div>                        
                    </div>                      
                </form>    
            </div>
        </div>
    </div>
</div>