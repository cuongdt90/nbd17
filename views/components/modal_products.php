<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly  ?>
<div id="dg-load-product"  class="modal fade nbdesigner_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 15px;">
                <b>{{(langs['CHOOSE_PRODUCT']) ? langs['CHOOSE_PRODUCT'] : "Choose product"}}</b>
                <button style="margin-top: 0;" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>	
            </div>            
            <div class="modal-body" style="padding: 15px;">
                <div id="nbd-list-product" class="nbd-list-product">
                    <span ng-repeat="product in listProducts | limitTo : listProductsPageSize" class="nbdesigner-template shadow hover-shadow" ng-click="switchProduct(product)" title="{{product.name}}">
                        <img style="max-width: 100%;" ng-src="{{product.src}}" />
                    </span> 
                </div>    
                <div ng-show=" _.size(listProducts) > listProductsPageSize">
                    <button class="btn btn-primary shadow nbdesigner_upload btn-dialog" ng-click="loadMoreProduct()">{{(langs['MORE']) ? langs['MORE'] : "More"}}</button>
                    &nbsp;{{(langs['DISPLAYED']) ? langs['DISPLAYED'] : "Displayed"}} {{(listProductsPageSize < _.size(listProducts)) ? listProductsPageSize : _.size(listProducts)}}/{{_.size(listProducts)}}
                </div>                 
            </div>
        </div>
    </div>
</div>
