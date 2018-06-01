<div class="tab" ng-if="settings['nbdesigner_enable_text'] == 'yes'" id="tab-typography" nbd-scroll="scrollLoadMore(container, type)" data-container="#tab-typography" data-type="typography">
    <div class="tab-main tab-scroll">
        <div class="typography-head">
            <span ng-click='debug()' class="text-guide" style="color: #4F5467; margin-bottom: 20px;display: block;"><?php _e('Click to add text','nbd-online-design'); ?></span>
            <div class="head-main">
                <span class="text-heading" ng-click='addText()' style="color: #4F5467; display: block; font-size: 40px; font-weight: 700"><?php _e('Add heading','web-to-print-online-designer'); ?></span>
                <span class="text-sub-heading" ng-click="addImage()" style="display: block; font-size: 24px; font-weight: 500; color: #4F5467"><?php _e('Add subheading','nbd-online-design');?></span>
                <span ng-click="debug2()" class="text-body" style="display: block;color: #4F5467"><?php _e('Add subheading','nbd-online-design'); ?></span>
            </div>
        </div>
        <div class="typography-body">
            <ul class="typography-items">
                <li class="typography-item" ng-repeat="typo in resource.typography.data | limitTo: resource.typography.currentPage * resource.typography.perPage" repeat-end="onEndRepeat('typography')">
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

