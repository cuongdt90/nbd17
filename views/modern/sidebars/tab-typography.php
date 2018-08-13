<div class="tab <?php if($product_data["option"]['admindesign'] == "0" ) echo 'active'; ?>" ng-if="settings['nbdesigner_enable_text'] == 'yes'" id="tab-typography" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-typography" data-type="typography" data-offset="20">
    <div class="tab-main tab-scroll">
        <div class="typography-head">
            <span class="text-guide" style="color: #4F5467; margin-bottom: 20px;display: block;"><?php _e('Click to add text','web-to-print-online-designer'); ?></span>
            <div class="head-main">
                <span class="text-heading" ng-click='addText("<?php _e('Heading','web-to-print-online-designer'); ?>", "heading")' style="color: #4F5467; display: block; font-size: 42px; font-weight: 700"><?php _e('Add heading','web-to-print-online-designer'); ?></span>
                <span class="text-sub-heading" ng-click="addText('<?php _e('Subheading','web-to-print-online-designer');?>', 'subheading')" style="display: block; font-size: 30px; font-weight: 500; color: #4F5467"><?php _e('Add subheading','web-to-print-online-designer');?></span>
                <span ng-click="addText('<?php _e('Add a little bit of body text','web-to-print-online-designer'); ?>')" class="text-body" style="display: block;color: #4F5467; font-size: 16px;"><?php _e('Add a little bit of body text','web-to-print-online-designer'); ?></span>
            </div>
        </div>
        <hr style="border-top: 1px solid rgba(255,255,255,0.5);margin: 0 10px 20px;"/>
        <div class="typography-body">
            <ul class="typography-items">
                <li nbd-drag="typo.folder" type="typo" ng-click="insertTypography(typo)" class="typography-item" ng-repeat="typo in resource.typography.data | limitTo: resource.typography.filter.currentPage * resource.typography.filter.perPage" repeat-end="onEndRepeat('typography')">
                    <img ng-src="{{generateTypoLink(typo)}}"alt="Typography" />
                </li>
            </ul>
            <div class="loading-photo" style="width: 40px; height: 40px;">
                <svg class="circular" viewBox="25 25 50 50">
                    <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                </svg>
            </div>                
        </div>
    </div>
</div>