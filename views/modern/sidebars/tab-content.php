<div class="tabs-content">
    <i class="fa fa-times" aria-hidden="true"></i>
    <div class="tab tab-first active" id="tab-product-template">
        <div class="nbd-search" ng-if="settings.ui_mode != '1'">
            <input type="search" name="search" placeholder="search"/>
            <i class="icon-nbd icon-nbd-fomat-search"></i>
        </div>
        <div class="tab-template" id="tab-template">
            <i class="icon-nbd icon-nbd-fomat-highlight-off close-template"></i>
            <div class="tab-main tab-scroll">
                <div class="nbd-items-dropdown">
                    <div class="main-items">
                        <div class="items">
                            <div class="item" data-type="business-card" data-api="true">
                                <div class="main-item">
                                    <div class="item-img">
                                        <img src="<?php echo NBDESIGNER_ASSETS_URL . 'images/business.jpg';?>" alt="Image Template">
                                    </div>
                                    <div class="item-info">
                                        <span class="item-name" title="Business Card"><?php _e('Business Card','web-to-print-online-designer'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pointer"></div>
                    </div>
                    <div class="loading-photo" style="width: 40px; height: 40px;">
                        <svg class="circular" viewBox="25 25 50 50">
                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
                        </svg>
                    </div>
                    <div class="result-loaded">
                        <div class="nbdesigner-gallery">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'tab-typography.php'; ?>    
    <?php include 'tab-clipart.php'; ?>    
    <?php include 'tab-photo.php'; ?> 
    <?php include 'tab-elements.php'; ?>
    <?php include 'tab-layer.php'; ?>
</div>